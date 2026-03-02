@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Kelola Pengguna</h2>
                <p class="text-gray-500 font-bold mb-4 uppercase text-[10px] tracking-widest mt-2">
                    Total: {{ $allUsers->count() }} Pengguna Terdaftar
                </p>
            </div>
            <button onclick="toggleModal('modalTambah')"
                class="bg-red-600 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-600/20 transform hover:-translate-y-1">
                + Tambah Akun Baru
            </button>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-600 rounded-r-2xl">
                <p class="text-emerald-600 font-bold text-xs uppercase tracking-widest">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl">
                <p class="text-red-700 text-[10px] font-black uppercase tracking-widest mb-2">Gagal Menambah Akun:</p>
                <ul class="list-disc list-inside text-xs font-bold text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                    @foreach ($allUsers as $u)
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
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-3 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
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

    <div id="modalTambah" class="hidden fixed inset-0 z-50 items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl border border-gray-100 transform transition-all">
            <div class="mb-8 text-center">
                <h3 class="text-xl font-black text-gray-900 uppercase tracking-widest">Tambah User Baru</h3>
                <p class="text-gray-400 text-[10px] font-bold uppercase mt-1">Pastikan data yang dimasukkan valid</p>
            </div>
            
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Masukkan nama"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-sm text-gray-900 font-bold outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all"
                        required>
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Email</label>
                    <input type="email" name="email" placeholder="email@contoh.com"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-sm text-gray-900 font-bold outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all"
                        required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Password</label>
                    <input type="password" name="password" placeholder="Min. 6 Karakter"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-sm text-gray-900 font-bold outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all"
                        required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Role Akses</label>
                    <select name="role"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-sm text-gray-900 font-bold outline-none focus:border-red-600 transition-all appearance-none">
                        <option value="user">User (Pendaftar)</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="button" onclick="toggleModal('modalTambah')"
                        class="w-1/2 py-4 text-gray-400 font-black uppercase text-[10px] tracking-widest hover:text-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="w-1/2 py-4 bg-gray-900 text-white font-black uppercase text-[10px] tracking-widest rounded-2xl hover:bg-black shadow-lg shadow-gray-900/20 transition-all transform hover:-translate-y-1">
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden'; 
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        window.onclick = function(event) {
            const modal = document.getElementById('modalTambah');
            if (event.target == modal) {
                toggleModal('modalTambah');
            }
        }
    </script>
@endsection