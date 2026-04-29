@extends('admin.dashboard')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <div class="mb-8 border-b-2 border-gray-100 pb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-900 transition-colors p-2 hover:bg-gray-100 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Edit Pengguna</h1>
                    <p class="text-sm font-medium text-gray-600 mt-2">
                        Perbarui informasi profil dan hak akses kata sandi pengguna sistem.
                    </p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-8 p-5 bg-red-50 border-l-4 border-red-600 rounded-r-xl shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-red-800 text-sm font-black uppercase tracking-wide">Pembaruan Gagal</p>
                </div>
                <ul class="list-disc list-inside text-sm font-semibold text-red-700 space-y-1 ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-3xl p-8 md:p-10 shadow-sm">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">MENGEDIT AKUN</p>
                            <p class="text-lg font-black text-gray-900 leading-tight">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="hidden sm:block text-right">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-widest {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $user->role == 'admin' ? 'bg-red-500' : 'bg-blue-500' }}"></span>
                            {{ $user->role }}
                        </span>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Informasi Dasar</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all outline-none"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all outline-none"
                                placeholder="email@example.com" required>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200">

                <div>
                    <div class="mb-5">
                        <h2 class="text-xl font-bold text-gray-900">Keamanan Sandi</h2>
                        <p class="text-sm font-medium text-gray-500 mt-1">Kosongkan kolom ini jika Anda tidak ingin mengubah kata sandi pengguna ini.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" 
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all outline-none">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Sandi Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ketik ulang kata sandi" 
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all outline-none">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 mt-6">
                    <a href="{{ route('admin.users.index') }}"
                        class="w-full sm:w-1/3 py-4 text-center text-white font-bold text-sm border border-gray-300 bg-red-600 rounded-xl hover:bg-red-700 transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-2/3 py-4 bg-gray-900 text-white font-black uppercase text-sm tracking-widest rounded-xl hover:bg-black shadow-lg shadow-gray-900/30 transition-all transform hover:-translate-y-1">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection