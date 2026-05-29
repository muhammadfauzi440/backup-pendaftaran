<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Instansi;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PendaftaranController extends Controller
{
    //public function
    public function index(Request $request)
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::with(['instansi', 'dokumen', 'anggota'])
            ->where('user_id', $user->id)
            ->first();

        $instansis = Instansi::orderBy('nama_instansi', 'asc')->get();
        $tipe = $request->query('tipe', $pendaftaran ? $pendaftaran->tipe_pendaftaran : 'individu');

        return view('user.daftar.index', compact('pendaftaran', 'instansis', 'tipe'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $this->normalizeInstansiId($request);
        $request->validate($this->getValidationRules(isUpdate: false));

        DB::beginTransaction();
        try {
            $pendaftaran = Pendaftaran::create($this->buildPendaftaranData($request, $user->id));
            $this->handleAnggota($pendaftaran, $request);
            $this->handleDokumenBaru($pendaftaran, $request);
            DB::commit();

            $pendaftaran->refresh();
            $pesan = $this->sendNewRegistrationNotifications($pendaftaran, $user, $request->kontak);

            return redirect()->route('user.dashboard')->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();

        Gate::authorize('update', $pendaftaran);

        $this->normalizeInstansiId($request);
        $request->validate($this->getValidationRules(isUpdate: true, pendaftaranId: $pendaftaran->id));

        DB::beginTransaction();
        try {
            $pendaftaran->update($this->buildPendaftaranData($request, $user->id));
            $this->handleAnggota($pendaftaran, $request);
            $this->handleDokumenUpdate($pendaftaran, $request);
            DB::commit();

            return redirect()->route('user.dashboard')->with('success', 'Data formulir berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function cekStatusPublic(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode' => 'required|string|min:3|max:50'
            ]);

            $kode = strtoupper(trim($validated['kode']));

            $pendaftaran = Pendaftaran::with('user')
                ->where('kode_pendaftaran', $kode)
                ->first();

            if ($pendaftaran) {
                return response()->json([
                    'success' => true,
                    'nama'    => $pendaftaran->user->name ?? 'Tidak diketahui',
                    'status'  => $pendaftaran->status,
                    'catatan' => $pendaftaran->catatan_admin ?? null,
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Kode pendaftaran tidak ditemukan.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kode pendaftaran tidak boleh kosong.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server. Coba lagi nanti.'
            ], 500);
        }
    }

    public function resendNotifikasi(Request $request)
    {
        $user        = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $channel = $request->input('channel'); // 'buat whatsapp' atau 'email'

        if ($channel === 'whatsapp') {
            try {
                $this->sendWhatsAppNotification($pendaftaran->kontak, $pendaftaran->kode_pendaftaran);
                return redirect()->route('user.dashboard')
                    ->with('success', 'Kode pendaftaran berhasil dikirim ulang via WhatsApp ke nomor ' . $pendaftaran->kontak . '.');
            } catch (\Exception $e) {
                Log::error('Resend WA Gagal: ' . $e->getMessage());
                return redirect()->route('user.dashboard')
                    ->with('error', 'Gagal mengirim notifikasi via WhatsApp. Pastikan nomor HP Anda aktif dan coba beberapa saat lagi.');
            }
        } elseif ($channel === 'email') {
            try {
                $pendaftaran->load(['instansi', 'anggota']);
                Mail::to($user->email)->send(new \App\Mail\KodePendaftaranMail($pendaftaran));
                return redirect()->route('user.dashboard')
                    ->with('success', 'Kode pendaftaran berhasil dikirim ulang via Email ke ' . $user->email . '.');
            } catch (\Exception $e) {
                Log::error('Resend Email Gagal: ' . $e->getMessage());
                return redirect()->route('user.dashboard')
                    ->with('error', 'Gagal mengirim notifikasi via Email. Silakan coba beberapa saat lagi.');
            }
        }

        return redirect()->route('user.dashboard')
            ->with('error', 'Pilihan channel tidak valid.');
    }

    //private function

    /**
     * Ubah nilai 'lain' pada instansi_id menjadi null agar lolos validasi exists.
     */
    private function normalizeInstansiId(Request $request): void
    {
        if ($request->instansi_id === 'lain') {
            $request->merge(['instansi_id' => null]);
        }
    }

    /**
     * Kembalikan aturan validasi. Bedakan antara store (dokumen wajib)
     * dan update (dokumen opsional, nim_nisn ignore record saat ini).
     */
    private function getValidationRules(bool $isUpdate, ?int $pendaftaranId = null): array
    {
        return [
            'instansi_id'   => 'required_without:instansi_lain|nullable|exists:instansis,id',
            'instansi_lain' => 'required_without:instansi_id|nullable|string|max:255',
            'kategori'      => 'required|in:siswa,mahasiswa',
            'nim_nisn'      => [
                'required',
                'numeric',
                'digits_between:5,30',
                Rule::unique('pendaftarans', 'nim_nisn')->ignore($pendaftaranId),
            ],

            'jurusan'          => 'required|string',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after:tanggal_mulai',
            'tempat_lahir'     => 'required|string',
            'tanggal_lahir'    => 'required|date',
            'alamat'           => 'required|string',
            'jenis_kelamin'    => 'required|in:laki-laki,perempuan',
            'kontak'           => 'required|numeric|digits_between:8,20',
            'tipe_pendaftaran' => 'required|in:individu,kelompok',

            'anggota'                   => 'nullable|array',
            'anggota.*.nama'            => 'required_with:anggota|string|max:255',
            'anggota.*.nim_nisn'        => 'required_with:anggota|numeric|digits_between:5,30',
            'anggota.*.jurusan'         => 'required_with:anggota|string|max:100',
            'anggota.*.tempat_lahir'    => 'required_with:anggota|string|max:100',
            'anggota.*.tanggal_lahir'   => 'required_with:anggota|date',
            'anggota.*.jenis_kelamin'   => 'required_with:anggota|in:laki-laki,perempuan',
            'anggota.*.kontak'          => 'required_with:anggota|numeric|digits_between:8,20',
            'anggota.*.alamat'          => 'required_with:anggota|string',

            'dokumen'       => $isUpdate ? 'nullable|array' : 'required|array|min:1',
            'dokumen.*'     => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tipe_dokumen'  => 'required|array',
            'tipe_dokumen.*' => 'required|string',
        ];
    }

    /**
     * Susun array data utama Pendaftaran dari request.
     */
    private function buildPendaftaranData(Request $request, int $userId): array
    {
        $data = $request->except(['dokumen', 'tipe_dokumen', 'anggota', 'status', 'catatan_admin', 'dokumen_id']);

        if ($request->instansi_id) {
            $data['instansi_id']   = $request->instansi_id;
            $data['instansi_lain'] = null;
        } else {
            $data['instansi_id']   = null;
            $data['instansi_lain'] = $request->instansi_lain;
        }

        $data['user_id']      = $userId;
        $data['durasi_bulan'] = (int) \Carbon\Carbon::parse($request->tanggal_mulai)
            ->diffInMonths(\Carbon\Carbon::parse($request->tanggal_selesai));

        return $data;
    }

    /**
     * Simpan atau hapus data anggota kelompok sesuai tipe pendaftaran.
     */
    private function handleAnggota(Pendaftaran $pendaftaran, Request $request): void
    {
        if ($request->tipe_pendaftaran === 'kelompok' && $request->has('anggota')) {
            $pendaftaran->anggota()->delete();
            $pendaftaran->anggota()->createMany($request->anggota);
        } elseif ($request->tipe_pendaftaran === 'individu') {
            $pendaftaran->anggota()->delete();
        }
    }

    /**
     * Upload dan simpan dokumen-dokumen baru (untuk store, atau tambah dokumen baru saat update).
     */
    private function handleDokumenBaru(Pendaftaran $pendaftaran, Request $request): void
    {
        if (!$request->hasFile('dokumen')) {
            return;
        }

        $tipeList = $request->tipe_dokumen ?? [];
        foreach ($request->file('dokumen') as $key => $file) {
            if ($file->isValid()) {
                $path = $file->store('pendaftaran/dokumen', 'public');
                Dokumen::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'tipe_dokumen'   => $tipeList[$key] ?? 'Lainnya',
                    'nama_dokumen'   => $file->getClientOriginalName(),
                    'file_path'      => $path,
                ]);
            }
        }
    }

    /**
     * Ganti file dokumen yang sudah ada (berdasarkan ID), atau tambah dokumen baru.
     */
    private function handleDokumenUpdate(Pendaftaran $pendaftaran, Request $request): void
    {
        if (!empty($request->dokumen_id)) {

            foreach ($request->dokumen_id as $dokId) {
                $fieldName = 'dokumen_' . $dokId;
                if (!$request->hasFile($fieldName) || !$request->file($fieldName)->isValid()) {
                    continue;
                }

                $oldDok = Dokumen::find($dokId);
                if (!$oldDok) {
                    continue;
                }

                if (Storage::disk('public')->exists($oldDok->file_path)) {
                    Storage::disk('public')->delete($oldDok->file_path);
                }

                $oldDok->update([
                    'file_path'    => $request->file($fieldName)->store('pendaftaran/dokumen', 'public'),
                    'nama_dokumen' => $request->file($fieldName)->getClientOriginalName(),
                ]);
            }

            return;
        }

        $this->handleDokumenBaru($pendaftaran, $request);
    }

    /**
     * Kirim notifikasi WhatsApp dan Email setelah pendaftaran baru berhasil.
     * Kembalikan pesan flash yang sesuai dengan status pengiriman.
     */
    private function sendNewRegistrationNotifications(Pendaftaran $pendaftaran, $user, string $kontak): string
    {
        $waStatus    = 'Sukses';
        $emailStatus = 'Sukses';

        try {
            $this->sendWhatsAppNotification($kontak, $pendaftaran->kode_pendaftaran);
        } catch (\Exception $e) {
            $waStatus = 'Gagal';
            Log::error("Kirim WA Pendaftaran Gagal: " . $e->getMessage());
        }

        try {
            $pendaftaran->load(['instansi', 'anggota']);
            Mail::to($user->email)->send(new \App\Mail\KodePendaftaranMail($pendaftaran));
        } catch (\Exception $e) {
            $emailStatus = 'Gagal';
            Log::error("Kirim Email Pendaftaran Gagal: " . $e->getMessage());
        }

        if ($waStatus === 'Sukses' && $emailStatus === 'Sukses') {
            return 'Pendaftaran berhasil disubmit! Kode Pendaftaran telah dikirim ke WhatsApp dan Email Anda.';
        } elseif ($waStatus === 'Sukses' && $emailStatus === 'Gagal') {
            return 'Pendaftaran berhasil! Kode dikirim ke WhatsApp Anda, namun gagal dikirim ke Email. Silakan salin kode langsung dari Dashboard.';
        } elseif ($waStatus === 'Gagal' && $emailStatus === 'Sukses') {
            return 'Pendaftaran berhasil! Kode dikirim ke Email Anda, namun sistem gagal mengirim ke WhatsApp. Silakan salin kode langsung dari Dashboard.';
        } else {
            return 'Pendaftaran berhasil! Namun sistem sedang sibuk sehingga kode gagal dikirim via Email & WhatsApp. Silakan salin kode langsung dari Dashboard.';
        }
    }

    /**
     * Kirim pesan WhatsApp via WAHA API.
     */
    private function sendWhatsAppNotification(string $no_hp, string $kode): void
    {
        if (str_starts_with($no_hp, '0')) {
            $no_hp = '62' . substr($no_hp, 1);
        }

        $pesan  = "Terima kasih telah mendaftar di Portal Magang PT Global Intermedia Nusantara.\n\n";
        $pesan .= "Kode pendaftaran Anda adalah: *{$kode}*\n\n";
        $pesan .= "Gunakan kode ini untuk mengecek status pendaftaran Anda kapan saja melalui portal publik kami.\n\n";
        $pesan .= "---\n";
        $pesan .= "📧 *Cek Email Anda!*\n";
        $pesan .= "Detail lengkap pendaftaran (nama, instansi, periode magang, dll) telah dikirimkan ke alamat email yang Anda daftarkan. Silakan buka email Anda untuk melihat ringkasan pendaftaran secara lengkap.\n\n";
        $pesan .= "_Pesan ini dikirim otomatis oleh sistem, mohon tidak membalas pesan ini._";

        $response = Http::withHeaders(['X-Api-Key' => env('WAHA_API_KEY')])
            ->timeout(10)
            ->post(env('WAHA_API_URL') . '/api/sendText', [
                'session' => 'default',
                'chatId'  => $no_hp . '@c.us',
                'text'    => $pesan,
            ]);

        if (!$response->successful()) {
            throw new \Exception("Status WAHA: " . $response->status() . " - " . $response->body());
        }
    }
}
