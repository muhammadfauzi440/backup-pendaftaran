<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Instansi;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        return view('user.daftar', compact('pendaftaran', 'instansis', 'tipe'));
    }

    public function storeOrUpdate(Request $request)
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        $rules = ([
            'instansi_id' => 'required|exists:instansis,id',
            'kategori' => 'required|in:siswa,mahasiswa',
            'nim_nisn' => 'required|string|max:30|unique:pendaftarans,nim_nisn,' . ($pendaftaran->id ?? NULL),
            'kelas_semester' => 'required|string',
            'jurusan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'agama' => 'required|string',
            'kontak' => 'required|string',

            'tipe_pendaftaran' => 'required|in:individu,kelompok',
            'anggota' => 'nullable|array',
            'anggota.*.nama' => 'required_with:anggota|string|max:255',
            'anggota.*.nim_nisn' => 'required_with:anggota|string|max:30',
            
            'dokumen' => $pendaftaran ? 'nullable|array' : 'required|array|min:1',
            'dokumen.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tipe_dokumen' => 'required|string',
            'tipe_dokumen.*' => 'required|string',
        ]);

        $request->validate($rules);
        
        DB::beginTransaction();
        try {
            $mulai = Carbon::parse($request->tanggal_mulai);
            $selesai = Carbon::parse($request->tanggal_selesai);
            $durasi = (int) $mulai->diffInMonths($selesai);

            $data = $request->only([
                'instansi_id',
                'kategori',
                'nim_nisn',
                'kelas_semester',
                'jurusan',
                'tanggal_mulai',
                'tanggal_selesai',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'jenis_kelamin',
                'agama',
                'kontak'
            ]);

            $data['user_id'] = $user->id;
            $data['durasi_bulan'] = $durasi ?? 0;

            if ($pendaftaran) {
                $pendaftaran->update($data);
            } else {
                $pendaftaran = Pendaftaran::create($data);
            }

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $key => $file) {
                    $path = $file->store('pendaftaran/dokumen', 'public');
                    Dokumen::create([
                        'pendaftaran_id' => $pendaftaran->id,
                        'tipe_dokumen' => $request->tipe_dokumen[$key] ?? 'Lainnya',
                        'nama_dokumen' => $file->getClientOriginalName(),
                        'file_path' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('user.dashboard')->with('success', 'Data pendaftaran berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function cekStatusPublic($kode)
    {
        $pendaftaran = Pendaftaran::with('user')
        ->where('kode_pendaftaran', $kode)
        ->first();

        if ($pendaftaran) {
            return response()->json([
                'success' => true,
                'nama' => $pendaftaran->user->name,
                'status' => $pendaftaran->status,
                'catatan' => $pendaftaran->catatan_admin
            ]);
        }

        return response()->json(['success' => false]);
    }
}
