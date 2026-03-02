@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Kelola Instansi</h1>
                <p class="text-gray-500 font-bold mb-4">Tambah atau hapus daftar Instansi</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-600 rounded-r-2xl">
                <p class="text-emerald-600 font-bold text-xs uppercase tracking-widest">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        <div class="bg-white border-2 border-gray-50 p-8 rounded-[2.5rem] shadow-sm mb-10">
            <form action="{{ route('admin.instansi.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nama Instansi</label>
                        <input class="w-full border-gray-100 bg-gray-50 border p-3.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-red-600/20 focus:border-red-600 transition-all" 
                               type="text" name="nama_instansi" placeholder="Contoh: Universitas Gajah Mada" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Alamat</label>
                        <input class="w-full border-gray-100 bg-gray-50 border p-3.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-red-600/20 focus:border-red-600 transition-all" 
                               type="text" name="alamat_instansi" placeholder="Alamat Lengkap" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Kontak</label>
                        <input class="w-full border-gray-100 bg-gray-50 border p-3.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-red-600/20 focus:border-red-600 transition-all" 
                               type="text" name="kontak_instansi" placeholder="No. Telp / Email" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tipe</label>
                        <select class="w-full border-gray-100 bg-gray-50 border p-3.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-red-600/20 focus:border-red-600 transition-all appearance-none" name="tipe" id="tipe" required>
                            <option value="" disabled selected>Pilih Tipe</option>
                            <option value="sekolah">Sekolah</option>
                            <option value="universitas">Universitas</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="bg-gray-900 text-white w-full py-4 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-gray-900/20 hover:bg-black transition-all transform hover:-translate-y-1">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative w-full md:w-1/2">
                <form action="{{ route('admin.instansi.index') }}" method="GET" class="flex gap-2">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-11 pr-6 py-3 border-2 border-gray-50 rounded-2xl text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" 
                            placeholder="Cari nama Instansi...">
                    </div>
                    <button type="submit"
                        class="bg-gray-100 text-gray-900 px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-900 hover:text-white transition-all shadow-sm">
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('admin.instansi.index') }}"
                            class="bg-red-50 text-red-600 px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-sm">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="bg-white border-2 border-gray-50 rounded-[2.5rem] shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-900 text-white text-[10px] font-black uppercase tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-5">Nama Instansi</th>
                        <th class="px-8 py-5">Alamat</th>
                        <th class="px-8 py-5">Kontak</th>
                        <th class="px-8 py-5 text-center">Tipe</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @foreach ($instansis as $i)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-8 py-6 text-sm font-black text-gray-900">{{ $i->nama_instansi }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-500">{{ $i->alamat_instansi }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-500">{{ $i->kontak_instansi }}</td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                                    {{ $i->tipe == 'universitas' ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600' }}">
                                    {{ $i->tipe }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('admin.instansi.edit', $i->id) }}" 
                                       class="bg-gray-100 hover:bg-blue-600 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase transition-all shadow-sm">
                                       Edit
                                    </a>
                                    <form action="{{ route('admin.instansi.destroy', $i->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin hapus data ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 text-white hover:bg-red-900 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase transition-all shadow-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection