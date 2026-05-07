@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Kelola Pengguna</h2>
                <p class="text-gray-500 font-bold mb-4 uppercase text-[10px] tracking-widest mt-2">
                    Total: {{ $users->count() }} Pengguna Terdaftar
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
                    @foreach ($users as $u)
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
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="inline">
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