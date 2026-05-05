<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instansi;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $instansis = Instansi::when($search, function ($query, $search) {
            $keywords = explode(' ', $search);

            foreach ($keywords as $word) {
                if (strlen($word) <= 1) {
                    continue;
                }

                $query->where(function ($q) use ($word) {
                    $q->where('nama_instansi', 'like', "%{$word}%")
                        ->orWhere('alamat_instansi', 'like', "%{$word}%");
                });
            }
        })
            ->latest()
            ->get();

        return view('admin.instansi.index', compact('instansis'));
    }

    public function edit($id)
    {
        $instansi = Instansi::findOrFail($id);
        return view('admin.instansi.edit', compact('instansi'));
    }

    public function update(Request $request, $id)
    {
        $instansi = Instansi::findOrFail($id);

        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255|unique:instansis,nama_instansi,' . $id,
            'alamat_instansi' => 'required|string',
            'kontak_instansi' => 'required|string|min:8',
            'tipe' => 'required|in:sekolah,universitas',
        ]);

        try {
            $instansi->update($validated);
            return redirect()->route('admin.instansi.index')->with('success', 'Data Instansi berhasil diperbarui');
        } catch (\Exception $e) {
           return back()->withInput()->withErrors(['error' => 'Gagal memperbarui data']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required|unique:instansis|string|max:255',
            'alamat_instansi' => 'required|string',
            'kontak_instansi' => 'required|string|min:8',
            'tipe' => 'required|in:sekolah,universitas',
        ]);

        Instansi::create($request->all());

        return redirect()->route('admin.instansi.index')->with('success', 'Data Instansi berhasil ditambahkan');
    }

    public function destroy(Instansi $instansi)
    {
        $jumlahPendaftar = $instansi->pendaftaran()->count();

        if ($jumlahPendaftar > 0) {
            return redirect()->route('admin.instansi.index')
                ->with('error', "Instansi \"{$instansi->nama_instansi}\" tidak dapat dihapus karena masih digunakan oleh {$jumlahPendaftar} data pendaftaran.");
        }

        $instansi->delete();

        return redirect()->route('admin.instansi.index')->with('success', 'Data Instansi berhasil dihapus');
    }
}
