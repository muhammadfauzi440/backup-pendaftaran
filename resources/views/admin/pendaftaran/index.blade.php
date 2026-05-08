@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto py-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter mb-2">Kelola Pendaftar</h1>
                <p class="text-gray-500 font-bold text-sm">Total pengajuan: <span class="text-red-600 font-black">{{ $pendaftarans->total() }} Pendaftar</span></p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.export.excel', request()->query()) }}"
                    class="flex items-center gap-2 bg-emerald-600 text-white px-6 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-600/20 transform hover:-translate-y-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>

                <a href="{{ route('admin.export.pdf', request()->query()) }}"
                    class="flex items-center gap-2 bg-red-600 text-white px-6 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-red-500 transition-all shadow-lg shadow-red-600/20 transform hover:-translate-y-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>

        <div class="bg-white p-4 rounded-3xl border-2 border-gray-50 mb-6 shadow-sm flex flex-col md:flex-row gap-4">
            <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="flex-1 flex flex-col md:flex-row gap-4 w-full">
                <input type="hidden" name="per_page" value="{{ $perPage }}">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Pendaftar atau NIM/NISN..."
                    class="w-full md:flex-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-2xl focus:ring-gray-900 focus:border-gray-900 block p-3.5 font-medium">

                <select name="status" class="w-full md:w-48 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-2xl focus:ring-gray-900 focus:border-gray-900 block p-3.5 font-bold uppercase tracking-widest text-[10px]">
                    <option value="">-- SEMUA STATUS --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>PENDING</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>DITERIMA</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>DITOLAK</option>
                </select>

                <select name="per_page" onchange="this.form.submit()"
                    class="w-full md:w-36 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-2xl focus:ring-gray-900 focus:border-gray-900 block p-3.5 font-bold text-[10px] uppercase">
                    @foreach ([5, 10, 25, 50] as $opt)
                        <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>
                            {{ $opt }} / Halaman
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-gray-900 text-white px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                    Cari
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.pendaftaran.index', ['per_page' => $perPage]) }}" class="bg-gray-100 text-gray-600 px-6 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 transition text-center border border-gray-200">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        @if (session('success'))
            <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-emerald-700 font-bold text-xs uppercase tracking-widest">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 p-5 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-red-700 font-bold text-xs uppercase tracking-widest">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <form id="bulkDeleteForm" action="{{ route('admin.pendaftaran.bulkDestroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <div id="bulkDeleteContainer" class="hidden mb-4">
                <button type="button" onclick="confirmBulkDelete()" class="bg-red-600 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Data Terpilih (<span id="selectedCount">0</span>)
                </button>
            </div>

            <div class="bg-white border-2 border-gray-50 rounded-[2.5rem] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-900 text-white text-[10px] font-black uppercase tracking-[0.2em]">
                            <tr>
                                <th class="px-6 py-6 rounded-tl-[2.4rem] w-10 text-center">
                                    <input type="checkbox" id="selectAll" class="w-4 h-4 text-red-600 bg-gray-800 border-gray-700 rounded focus:ring-red-600 focus:ring-2">
                                </th>
                                <th class="px-4 py-6">Pendaftar & Tipe</th>
                                <th class="px-8 py-6">Instansi & Periode</th>
                                <th class="px-8 py-6 text-center">Status</th>
                                <th class="px-8 py-6 text-center rounded-tr-[2.4rem]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($pendaftarans as $p)
                                <tr class="hover:bg-gray-50/50 transition duration-200">
                                    <td class="px-6 py-6 align-top text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $p->id }}" class="rowCheckbox w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500">
                                    </td>

                                    <td class="px-4 py-6 align-top">
                                        <div class="font-black text-gray-900 text-sm mb-0.5">{{ $p->user->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3">
                                            {{ $p->nim_nisn }}</div>

                                        @if ($p->tipe_pendaftaran == 'kelompok')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 border border-red-100 text-[9px] font-black text-red-600 uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Kelompok (+{{ $p->anggota->count() }} Anggota)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 border border-gray-200 text-[9px] font-black text-gray-600 uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Individu
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-8 py-6 align-top">
                                        <div class="text-sm font-black text-gray-700 mb-1">
                                            <strong>{{ $p->nama_instansi_display }}</strong><br>
                                        </div>
                                        <div class="text-[10px] text-gray-500 font-bold tracking-widest flex flex-col gap-1 mt-2">
                                            <span class="uppercase">Mulai: <span class="text-gray-900">{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}</span></span>
                                            <span class="uppercase">Selesai: <span class="text-gray-900">{{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}</span></span>
                                        </div>
                                    </td>

                                    <td class="px-8 py-6 text-center align-top">
                                        <span class="inline-flex px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest
                                            {{ $p->status == 'pending' ? 'bg-amber-100 text-amber-600' : ($p->status == 'diterima' ? 'bg-emerald-100 text-emerald-600 ' : 'bg-red-100 text-red-600') }}">
                                            {{ $p->status }}
                                        </span>
                                    </td>

                                    <td class="px-8 py-6 align-top">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('admin.pendaftaran.show', $p->id) }}" class="bg-gray-900 text-white hover:bg-gray-800/80 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm" title="Lihat Detail">
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.pendaftaran.edit', $p->id) }}" class="bg-blue-600 text-white border border-blue-200 hover:bg-blue-700 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm" title="Edit Data">
                                                Edit
                                            </a>
                                            
                                            <a href="javascript:void(0)" onclick="confirmSingleDelete({{ $p->id }}, '{{ $p->user->name }}')" class="bg-red-600 text-white border border-red-200 hover:bg-red-700 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                                                Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-bold text-sm">Belum ada data pendaftar yang masuk / sesuai pencarian.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination info + kontrol --}}
            @if ($pendaftarans->hasPages() || $pendaftarans->total() > 0)
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">

                    {{-- Info teks --}}
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Menampilkan
                        <span class="text-gray-900">{{ $pendaftarans->firstItem() }}–{{ $pendaftarans->lastItem() }}</span>
                        dari
                        <span class="text-gray-900">{{ $pendaftarans->total() }}</span> data
                        &bull; Halaman <span class="text-gray-900">{{ $pendaftarans->currentPage() }}</span>
                        dari <span class="text-gray-900">{{ $pendaftarans->lastPage() }}</span>
                    </p>

                    {{-- Tombol navigasi halaman --}}
                    @if ($pendaftarans->hasPages())
                        <div class="flex items-center gap-1.5">
                            {{-- Prev --}}
                            @if ($pendaftarans->onFirstPage())
                                <span class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-300 cursor-not-allowed select-none">
                                    &laquo; Prev
                                </span>
                            @else
                                <a href="{{ $pendaftarans->previousPageUrl() }}"
                                    class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition-all">
                                    &laquo; Prev
                                </a>
                            @endif

                            {{-- Nomor halaman --}}
                            @foreach ($pendaftarans->getUrlRange(1, $pendaftarans->lastPage()) as $page => $url)
                                @if ($page == $pendaftarans->currentPage())
                                    <span class="w-10 h-10 flex items-center justify-center rounded-xl text-[10px] font-black bg-gray-900 text-white">
                                        {{ $page }}
                                    </span>
                                @elseif (abs($page - $pendaftarans->currentPage()) <= 2 || $page == 1 || $page == $pendaftarans->lastPage())
                                    <a href="{{ $url }}"
                                        class="w-10 h-10 flex items-center justify-center rounded-xl text-[10px] font-black bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition-all">
                                        {{ $page }}
                                    </a>
                                @elseif (abs($page - $pendaftarans->currentPage()) == 3)
                                    <span class="w-10 h-10 flex items-center justify-center text-gray-400 text-xs font-bold">…</span>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if ($pendaftarans->hasMorePages())
                                <a href="{{ $pendaftarans->nextPageUrl() }}"
                                    class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition-all">
                                    Next &raquo;
                                </a>
                            @else
                                <span class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-300 cursor-not-allowed select-none">
                                    Next &raquo;
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </form>

        <form id="singleDeleteForm" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </div>
@endsection