<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Exports\PendaftaranExport;
use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Mail\StatusPendaftaranMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'instansi', 'dokumen', 'anggota'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })->orWhere('nim_nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $allowed  = [5, 10, 25, 50];
        $perPage  = in_array((int) $request->per_page, $allowed) ? (int) $request->per_page : 10;

        $pendaftarans = $query->paginate($perPage)->withQueryString();
        return view('admin.pendaftaran.index', compact('pendaftarans', 'perPage'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'instansi', 'dokumen'])->findOrFail($id);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::with('dokumen')->findOrFail($id);
        $instansis = Instansi::orderBy('nama_instansi', 'asc')->get();

        return view('admin.pendaftaran.edit', compact('pendaftaran', 'instansis'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($request->instansi_id === 'lain') {
            $request->merge(['instansi_id' => null]);
        }

        $validatedData = $request->validate([
            'nim_nisn'        => 'required|string|max:25',
            'instansi_id'     => 'nullable|exists:instansis,id',
            'instansi_lain'   => 'required_without:instansi_id|nullable|string|max:255',
            'kategori'        => 'required|in:siswa,mahasiswa',
            'jurusan'         => 'required|string|max:100',
            'kelas_semester'  => 'required|string|max:50',
            'tempat_lahir'    => 'required|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|in:laki-laki,perempuan',
            'agama'           => 'required|string|max:50',
            'kontak'          => 'required|string|max:20',
            'alamat'          => 'required|string|max:500',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'durasi_bulan'    => 'nullable|integer|min:1|max:12',

            'anggota'                 => 'nullable|array',
            'anggota.*.nama'          => 'required_with:anggota|string|max:255',
            'anggota.*.nim_nisn'      => 'required_with:anggota|string|max:30',
            'anggota.*.jurusan'       => 'required_with:anggota|string|max:100',
            'anggota.*.kelas_semester' => 'required_with:anggota|string|max:100',
            'anggota.*.tempat_lahir'  => 'required_with:anggota|string|max:100',
            'anggota.*.tanggal_lahir' => 'required_with:anggota|date',
            'anggota.*.jenis_kelamin' => 'required_with:anggota|in:laki-laki,perempuan',
            'anggota.*.agama'         => 'required_with:anggota|string|max:50',
            'anggota.*.kontak'        => 'required_with:anggota|string|max:20',
            'anggota.*.alamat'        => 'required_with:anggota|string',

            'hapus_dokumen'   => 'nullable|array',
            'hapus_dokumen.*' => 'exists:dokumens,id',
            'dokumen_baru.*'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $instansiData = $request->instansi_id
                ? ['instansi_id' => $request->instansi_id, 'instansi_lain' => null]
                : ['instansi_id' => null, 'instansi_lain' => $request->instansi_lain];

            $pendaftaran->update(array_merge($request->only([
                'nim_nisn',
                'kategori',
                'jurusan',
                'kelas_semester',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'agama',
                'kontak',
                'alamat',
                'tanggal_mulai',
                'tanggal_selesai',
                'durasi_bulan'
            ]), $instansiData));

            if ($request->has('anggota')) {
                foreach ($request->anggota as $anggota_id => $data_anggota) {
                    \App\Models\AnggotaPendaftaran::where('id', $anggota_id)->update($data_anggota);
                }
            }

            if ($request->filled('hapus_dokumen')) {
                $dokumensToDelete = $pendaftaran->dokumen()->whereIn('id', $request->hapus_dokumen)->get();
                foreach ($dokumensToDelete as $dokumen) {
                    Storage::disk('public')->delete($dokumen->file_path);
                    $dokumen->delete();
                }
            }

            if ($request->hasFile('dokumen_baru')) {
                foreach ($request->file('dokumen_baru') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('pendaftaran/dokumen', $filename, 'public');

                    $pendaftaran->dokumen()->create([
                        'tipe_dokumen' => strtoupper($file->getClientOriginalExtension()),
                        'nama_dokumen' => $originalName,
                        'file_path'    => $path,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.pendaftaran.index')
                ->with('success', 'Profil dan berkas pendaftar berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $pendaftaran = Pendaftaran::with(['dokumen', 'user'])->findOrFail($id);

            AuditLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'Hapus Pendaftaran',
                'description' => 'Admin menghapus data pendaftaran milik ' . ($pendaftaran->user->name ?? 'User Terhapus') . " (Kode: {$pendaftaran->kode_pendaftaran})",
                'ip_address'  => request()->ip()
            ]);

            $pendaftaran->delete();

            DB::commit();
            return redirect()->route('admin.pendaftaran.index')
                ->with('success', 'Data pendaftaran dan berkas terkait telah dihapus secara permanen.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'catatan_admin' => 'required|string|min:5|max:500',
        ]);

        $pendaftaran = Pendaftaran::with('user')->findOrFail($id);

        try {
            DB::beginTransaction();

            $pendaftaran->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan_admin,
            ]);

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'Update Status Pendaftaran',
                'description' => "Admin mengubah status pendaftaran milik {$pendaftaran->user->name} (Kode: {$pendaftaran->kode_pendaftaran}) menjadi " . strtoupper($request->status),
                'ip_address' => $request->ip()
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }

        try {
            Mail::to($pendaftaran->user->email)->send(new StatusPendaftaranMail($pendaftaran));
            return redirect()->route('admin.pendaftaran.index')
                ->with('success', "Status pendaftaran berhasil diubah menjadi {$request->status} dan email notifikasi telah dikirim ke {$pendaftaran->user->email}.");
        } catch (\Exception $e) {
            return redirect()->route('admin.pendaftaran.index')
                ->with('error', "Status berhasil diubah, TETAPI gagal mengirim email notifikasi. Error: " . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PendaftaranExport($request->search, $request->status), 'laporan-pendaftaran-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Pendaftaran::with(['user', 'instansi'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })->orWhere('nim_nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pendaftarans = $query->get();
        $pdf = Pdf::loadView('admin.pendaftaran.pdf', compact('pendaftarans'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pendaftaran-' . now()->format('Y-m-d') . '.pdf');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:pendaftarans,id'
        ]);

        try {
            DB::beginTransaction();
            $pendaftarans = Pendaftaran::with('dokumen')->whereIn('id', $request->ids)->get();

            foreach ($pendaftarans as $pendaftaran) {
                $pendaftaran->delete();
            }

            DB::commit();
            return redirect()->route('admin.pendaftaran.index')
                ->with('success', count($request->ids) . ' data pendaftaran dan berkasnya berhasil dihapus massal.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal melakukan hapus massal: ' . $e->getMessage());
        }
    }

    public function auditLogs()
    {
        $logs = AuditLog::with('user')->latest()->paginate(20);
        return view('admin.audit-logs.index', compact('logs'));
    }
}
