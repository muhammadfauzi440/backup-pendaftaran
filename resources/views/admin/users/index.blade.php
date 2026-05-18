@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Kelola Pengguna</h2>
                <p class="text-gray-500 font-bold uppercase text-[10px] tracking-widest mt-2">
                    Total: <span class="text-gray-900">{{ $users->total() }}</span> Pengguna Terdaftar
                </p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="bg-red-600 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-600/20 transform hover:-translate-y-1">
                + Tambah Akun Baru
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-600 rounded-r-2xl">
                <p class="text-emerald-600 font-bold text-xs uppercase tracking-widest">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        {{-- Search & Filter --}}
        <div class="bg-white p-4 rounded-3xl border-2 border-gray-50 mb-6 shadow-sm">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 w-full">
                <input type="hidden" name="per_page" value="{{ $perPage }}">

                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau email pengguna..."
                    class="w-full md:flex-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-2xl focus:ring-gray-900 focus:border-gray-900 block p-3.5 font-medium">

                <select name="role"
                    class="w-full md:w-44 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-2xl focus:ring-gray-900 focus:border-gray-900 block p-3.5 font-bold uppercase tracking-widest text-[10px]">
                    <option value="">-- SEMUA ROLE --</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>USER</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>ADMIN</option>
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

                @if (request('search') || request('role'))
                    <a href="{{ route('admin.users.index', ['per_page' => $perPage]) }}"
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
                        <th class="px-8 py-5">Nama Pengguna</th>
                        <th class="px-8 py-5">Email</th>
                        <th class="px-8 py-5 text-center">Role</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($users as $u)
                        <tr class="hover:bg-gray-50/50 transition-all">
                            <td class="px-8 py-6">
                                <div class="font-black text-gray-900">{{ $u->name }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm font-bold text-gray-500">{{ $u->email }}</div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest
                                    {{ $u->role == 'admin' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('admin.users.edit', $u->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase transition-all shadow-sm">
                                        Edit
                                    </a>
                                    <button type="button"
                                        onclick="confirmDeleteUser({{ $u->id }}, '{{ addslashes($u->name) }}')"
                                        class="bg-red-600 text-white hover:bg-red-900 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase transition-all shadow-sm">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-bold text-sm">Tidak ada pengguna yang sesuai pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination info + kontrol --}}
        @if ($users->total() > 0)
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">

                {{-- Info teks --}}
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Menampilkan
                    <span class="text-gray-900">{{ $users->firstItem() }}–{{ $users->lastItem() }}</span>
                    dari
                    <span class="text-gray-900">{{ $users->total() }}</span> pengguna
                    &bull; Halaman <span class="text-gray-900">{{ $users->currentPage() }}</span>
                    dari <span class="text-gray-900">{{ $users->lastPage() }}</span>
                </p>

                {{-- Tombol navigasi halaman --}}
                @if ($users->hasPages())
                    <div class="flex items-center gap-1.5">
                        {{-- Prev --}}
                        @if ($users->onFirstPage())
                            <span class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-300 cursor-not-allowed select-none">
                                &laquo; Prev
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"
                                class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition-all">
                                &laquo; Prev
                            </a>
                        @endif

                        {{-- Nomor halaman --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="w-10 h-10 flex items-center justify-center rounded-xl text-[10px] font-black bg-gray-900 text-white">
                                    {{ $page }}
                                </span>
                            @elseif (abs($page - $users->currentPage()) <= 2 || $page == 1 || $page == $users->lastPage())
                                <a href="{{ $url }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-xl text-[10px] font-black bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition-all">
                                    {{ $page }}
                                </a>
                            @elseif (abs($page - $users->currentPage()) == 3)
                                <span class="w-10 h-10 flex items-center justify-center text-gray-400 text-xs font-bold">…</span>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"
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
    </div>

    {{-- Hidden form untuk SweetAlert delete --}}
    <form id="deleteUserForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

@push('scripts')
<script>
    function confirmDeleteUser(id, nama) {
        Swal.fire({
            title: 'Hapus Akun?',
            html: `Anda akan menghapus akun <strong>${nama}</strong>.<br><span class="text-xs text-gray-500">Tindakan ini tidak bisa dibatalkan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#111827',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl uppercase font-black tracking-widest text-[10px] px-6 py-3',
                cancelButton: 'rounded-xl uppercase font-black tracking-widest text-[10px] px-6 py-3'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteUserForm');
                form.action = `/admin/users/${id}`;
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection