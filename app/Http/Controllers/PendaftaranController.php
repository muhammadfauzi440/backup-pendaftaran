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

class PendaftaranController extends Controller
{
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

    public function storeOrUpdate(Request $request)
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        if ($pendaftaran) {
            Gate::authorize('update', $pendaftaran);
        }

        $rules = [
            'instansi_id' => 'required|exists:instansis,id',
            'kategori' => 'required|in:siswa,mahasiswa',
            'nim_nisn' => 'required|numeric|digits_between:5,30|unique:pendaftarans,nim_nisn,'.($pendaftaran->id ?? 'NULL'),
            'kelas_semester' => 'required|string',
            'jurusan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'agama' => 'required|string',
            'kontak' => 'required|numeric|digits_between:8,20',

            'tipe_pendaftaran' => 'required|in:individu,kelompok',

            'anggota' => 'nullable|array',
            'anggota.*.nama' => 'required_with:anggota|string|max:255',
            'anggota.*.nim_nisn' => 'required_with:anggota|numeric|digits_between:5,30',
            'anggota.*.jurusan' => 'required_with:anggota|string|max:100',
            'anggota.*.kelas_semester' => 'required_with:anggota|string|max:100',
            'anggota.*.tempat_lahir' => 'required_with:anggota|string|max:100',
            'anggota.*.tanggal_lahir' => 'required_with:anggota|date',
            'anggota.*.jenis_kelamin' => 'required_with:anggota|in:laki-laki,perempuan',
            'anggota.*.agama' => 'required_with:anggota|string|max:50',
            'anggota.*.kontak' => 'required_with:anggota|numeric|digits_between:8,20',
            'anggota.*.alamat' => 'required_with:anggota|string',

            'dokumen' => $pendaftaran ? 'nullable|array' : 'required|array|min:1',
            'dokumen.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tipe_dokumen' => 'required|array',
            'tipe_dokumen.*' => 'required|string',
        ];

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $mulai = \Carbon\Carbon::parse($request->tanggal_mulai);
            $selesai = \Carbon\Carbon::parse($request->tanggal_selesai);
            $durasi = (int) $mulai->diffInMonths($selesai);

            $data = $request->except(['dokumen', 'tipe_dokumen', 'anggota']);

            $data['user_id'] = $user->id;
            $data['durasi_bulan'] = $durasi ?? 0;

            $isNewRegistration = false;

            if ($pendaftaran) {
                $pendaftaran->update($data);
            } else {
                $pendaftaran = Pendaftaran::create($data);
                $isNewRegistration = true;
            }

            if ($request->tipe_pendaftaran === 'kelompok' && $request->has('anggota')) {
                $pendaftaran->anggota()->delete();
                $pendaftaran->anggota()->createMany($request->anggota);
            } elseif ($request->tipe_pendaftaran === 'individu') {
                $pendaftaran->anggota()->delete();
            }

            if ($request->hasFile('dokumen')) {
                $oldDokumens = Dokumen::where('pendaftaran_id', $pendaftaran->id)->get();

                foreach ($oldDokumens as $oldDokumen) {
                    if (Storage::disk('public')->exists($oldDokumen->file_path)) {
                        Storage::disk('public')->delete($oldDokumen->file_path);
                    }
                }

                Dokumen::where('pendaftaran_id', $pendaftaran->id)->delete();

                foreach ($request->file('dokumen') as $key => $file) {
                    if ($file->isValid()) {
                        $path = $file->store('pendaftaran/dokumen', 'public');
                        Dokumen::create([
                            'pendaftaran_id' => $pendaftaran->id,
                            'tipe_dokumen' => $request->tipe_dokumen[$key] ?? 'Lainnya',
                            'nama_dokumen' => $file->getClientOriginalName(),
                            'file_path' => $path,
                        ]);
                    }
                }
            }

            DB::commit();

            if ($isNewRegistration) {
                try {
                    $pendaftaran->refresh();
                    Mail::to($user->email)->send(new \App\Mail\KodePendaftaranMail($pendaftaran));

                    return redirect()->route('user.dashboard')->with('success', 'Pendaftaran berhasil disubmit! Kode Pendaftaran telah dikirim ke email Anda.');
                } catch (\Exception $e) {
                    return redirect()->route('user.dashboard')->with('success', 'Pendaftaran berhasil disubmit TETAPI sistem gagal mengirim kode ke email Anda. Silahkan salin kode langsung dari Dashboard');
                }
            }

            return redirect()->route('user.dashboard')->with('success', 'Data formulir berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Gagal: '.$e->getMessage());
        }
    }

    public function cekStatusPublic($kode, Request $request)
    {
        $request->validate([
            'kode' => 'required|string'
        ]);

        $kode = strtoupper($request->input('kode'));

        $pendaftaran = Pendaftaran::with('user')
            ->where('kode_pendaftaran', $kode)
            ->first();

        if ($pendaftaran) {
            return response()->json([
                'success' => true,
                'nama' => $pendaftaran->user->name,
                'status' => $pendaftaran->status,
                'catatan' => $pendaftaran->catatan_admin,
            ]);
        }

        return response()->json(['success' => false]);
    }
}
