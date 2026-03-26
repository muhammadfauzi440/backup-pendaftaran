@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto py-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter mb-2">Kelola Pendaftar</h1>
                <p class="text-gray-500 font-bold text-sm">Total pengajuan masuk: <span
                        class="text-red-600 font-black">{{ $pendaftarans->count() }} Pendaftar</span></p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.export.excel') }}"
                    class="flex items-center gap-2 bg-emerald-600 text-white px-6 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-600/20 transform hover:-translate-y-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>

                <a href="{{ route('admin.export.pdf') }}"
                    class="flex items-center gap-2 bg-red-600 text-white px-6 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-red-500 transition-all shadow-lg shadow-red-600/20 transform hover:-translate-y-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl shadow-sm flex items-center gap-3">
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

        <div class="bg-white border-2 border-gray-50 rounded-[2.5rem] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-900 text-white text-[10px] font-black uppercase tracking-[0.2em]">
                        <tr>
                            <th class="px-8 py-6 rounded-tl-[2.4rem]">Pendaftar & Tipe</th>
                            <th class="px-8 py-6">Instansi & Periode</th>
                            <th class="px-8 py-6 text-center">Status</th>
                            <th class="px-8 py-6 text-center rounded-tr-[2.4rem]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($pendaftarans as $p)
                            <tr class="hover:bg-gray-50/50 transition duration-200">

                                <td class="px-8 py-6 align-top">
                                    <div class="font-black text-gray-900 text-sm mb-0.5">{{ $p->user->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-3">
                                        {{ $p->nim_nisn }}</div>

                                    @if ($p->tipe_pendaftaran == 'kelompok')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 border border-red-100 text-[9px] font-black text-red-600 uppercase tracking-widest">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Kelompok (+{{ $p->anggota->count() }} Anggota)
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 border border-gray-200 text-[9px] font-black text-gray-600 uppercase tracking-widest">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Individu
                                        </span>
                                    @endif
                                </td>

                                <td class="px-8 py-6 align-top">
                                    <div class="text-sm font-black text-gray-700 mb-1">
                                        {{ $p->instansi->nama_instansi ?? 'Instansi tidak ditemukan' }}
                                    </div>
                                    <div
                                        class="text-[10px] text-gray-500 font-bold tracking-widest flex flex-col gap-1 mt-2">
                                        <span class="uppercase">Mulai: <span
                                                class="text-gray-900">{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}</span></span>
                                        <span class="uppercase">Selesai: <span
                                                class="text-gray-900">{{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}</span></span>
                                    </div>
                                </td>

                                <td class="px-8 py-6 text-center align-top">
                                    <span
                                        class="inline-flex px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest
                                        {{ $p->status == 'pending'
                                            ? 'bg-amber-100 text-amber-600'
                                            : ($p->status == 'diterima'
                                                ? 'bg-emerald-100 text-emerald-600 '
                                                : 'bg-red-100 text-red-600') }}">
                                        {{ $p->status }}
                                    </span>
                                </td>

                                <td class="px-8 py-6 align-top">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('admin.pendaftaran.show', $p->id) }}"
                                            class="bg-gray-900 text-white hover:bg-gray-800/80 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm"
                                            title="Lihat Detail">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.pendaftaran.edit', $p->id) }}"
                                            class="bg-blue-600 text-white border border-blue-200 hover:bg-blue-700 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm"
                                            title="Edit Data">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen data pendaftaran milik {{ $p->user->name }}?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 text-white border border-red-200 hover:bg-red-700 hover:text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 font-bold text-sm">Belum ada data pendaftar yang masuk.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
