@extends('admin.dashboard')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Edit Pengguna</h1>
                    <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mt-1">Ubah data pengguna</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl">
                <p class="text-red-700 text-[10px] font-black uppercase tracking-widest mb-2">Error:</p>
                <ul class="list-disc list-inside text-xs font-bold text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border-2 border-gray-50 rounded-[2.5rem] p-10 shadow-sm">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Info Pengguna -->
                <div class="pb-6 border-b border-gray-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Informasi Pengguna</p>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-black text-gray-900">{{ $user->name }}</p>
                            <p class="text-sm font-bold text-gray-500">{{ $user->email }}</p>
                            <p class="text-xs font-bold text-gray-400 mt-1">
                                Role: <span class="px-3 py-1 rounded-full text-[10px] font-black 
                                    {{ $user->role == 'admin' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                    {{ $user->role }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Nama -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-sm text-gray-900 font-bold outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all"
                        placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-sm text-gray-900 font-bold outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all"
                        placeholder="email@example.com" required>
                </div>

                <!-- Password Section -->
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Ubah Password (Opsional)</p>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Password Baru</label>
                        <input type="password" name="password" 
                            class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-sm text-gray-900 font-bold outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all"
                            placeholder="Min. 8 karakter (kosongkan jika tidak diubah)">
                        <p class="text-[10px] text-gray-400 ml-2">Biarkan kosong jika tidak ingin mengubah password</p>
                    </div>

                    <div class="space-y-2 mt-4">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-sm text-gray-900 font-bold outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all"
                            placeholder="Ketik ulang password">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6">
                    <a href="{{ route('admin.users.index') }}"
                        class="flex-1 py-4 text-gray-400 font-black uppercase text-[10px] tracking-widest hover:text-gray-600 transition-colors border border-gray-100 rounded-2xl text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 py-4 bg-gray-900 text-white font-black uppercase text-[10px] tracking-widest rounded-2xl hover:bg-black shadow-lg shadow-gray-900/20 transition-all transform hover:-translate-y-1">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
