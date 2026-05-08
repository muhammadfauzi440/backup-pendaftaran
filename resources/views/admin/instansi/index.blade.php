@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Kelola Instansi</h1>
                <p class="text-gray-500 font-bold uppercase text-[10px] tracking-widest mt-2">
                    Total: <span class="text-gray-900">{{ $instansis->total() }}</span> Instansi Terdaftar
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-600 rounded-r-2xl">
                <p class="text-emerald-600 font-bold text-xs uppercase tracking-widest">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 rounded-r-2xl">
                <p class="text-red-600 font-bold text-xs uppercase tracking-widest">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        {{-- Form Tambah Instansi --}}
        <div class="bg-white border-2 border-gray-50 p-8 rounded-[2.5rem] shadow-sm mb-8">
            <form action="{{ route('admin.instansi.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nama Instansi</label>
                        <input class="w-full border-gray-100 bg-gray-50 border p-3.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-red-600/20 focus:border-red-600 transition-all"
                               type="text" name="nama_instansi" placeholder="Contoh: Universitas Gadjah Mada" required>
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
                        <select class="w-full border-gray-100 bg-gray-50 border p-3.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-red-600/20 focus:border-red-600 transition-all appearance-none"
                                name="tipe" required>
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

        {{-- Search & Filter --}}
        <div class="bg-white p-4 rounded-3xl border-2 border-gray-50 mb-6 shadow-sm">
            <form action="{{ route('admin.instansi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 w-full">
                <input type="hidden" name="per_page" value="{{ $perPage }}">

                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau alamat instansi..."
                    class="w-full md:flex-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-2xl focus:ring-gray-900 focus:border-gray-900 block p-3.5 font-medium">

                <select name="tipe"
                    class="w-full md:w-44 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-2xl focus:ring-gray-900 focus:border-gray-900 block p-3.5 font-bold uppercase tracking-widest text-[10px]">
                    <option value="">-- SEMUA TIPE --</option>
                    <option value="sekolah" {{ request('tipe') == 'sekolah' ? 'selected' : '' }}>SEKOLAH</option>
                    <option value="universitas" {{ request('tipe') == 'universitas' ? 'selected' : '' }}>UNIVERSITAS</option>
                </select>

                <select name="per_page" onchange="this.form.submit()"
                    class="w-full md:w-36 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-2xl focus:ring-gray-900 focus:border-gray-900 block p-3.5 font-bold text-[10px] uppercase">
                    @foreach ([5, 10, 25, 50] as $opt)
                        <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>
                            {{ $opt }} / Halaman
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="bg-gray-900 text-white px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                    Cari
                </button>

                @if (request('search') || request('tipe'))
                    <a href="{{ route('admin.instansi.index', ['per_page' => $perPage]) }}"
                        class="bg-gray-100 text-gray-600 px-6 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 transition text-center border border-gray-200">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabel --}}
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
                    @forelse ($instansis as $i)
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
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase transition-all shadow-sm">
                                       Edit
                                    </a>
                                    <form action="{{ route('admin.instansi.destroy', $i->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin hapus data ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 text-white hover:bg-red-700 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase transition-all shadow-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-bold text-sm">Tidak ada instansi yang sesuai pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination info + kontrol --}}
        @if ($instansis->total() > 0)
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Menampilkan
                    <span class="text-gray-900">{{ $instansis->firstItem() }}–{{ $instansis->lastItem() }}</span>
                    dari
                    <span class="text-gray-900">{{ $instansis->total() }}</span> instansi
                    &bull; Halaman <span class="text-gray-900">{{ $instansis->currentPage() }}</span>
                    dari <span class="text-gray-900">{{ $instansis->lastPage() }}</span>
                </p>

                @if ($instansis->hasPages())
                    <div class="flex items-center gap-1.5">
                        @if ($instansis->onFirstPage())
                            <span class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-300 cursor-not-allowed select-none">&laquo; Prev</span>
                        @else
                            <a href="{{ $instansis->previousPageUrl() }}"
                                class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition-all">&laquo; Prev</a>
                        @endif

                        @foreach ($instansis->getUrlRange(1, $instansis->lastPage()) as $page => $url)
                            @if ($page == $instansis->currentPage())
                                <span class="w-10 h-10 flex items-center justify-center rounded-xl text-[10px] font-black bg-gray-900 text-white">{{ $page }}</span>
                            @elseif (abs($page - $instansis->currentPage()) <= 2 || $page == 1 || $page == $instansis->lastPage())
                                <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-xl text-[10px] font-black bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition-all">{{ $page }}</a>
                            @elseif (abs($page - $instansis->currentPage()) == 3)
                                <span class="w-10 h-10 flex items-center justify-center text-gray-400 text-xs font-bold">…</span>
                            @endif
                        @endforeach

                        @if ($instansis->hasMorePages())
                            <a href="{{ $instansis->nextPageUrl() }}"
                                class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition-all">Next &raquo;</a>
                        @else
                            <span class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-300 cursor-not-allowed select-none">Next &raquo;</span>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection