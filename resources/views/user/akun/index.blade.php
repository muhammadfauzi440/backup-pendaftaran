@extends('user.dashboard')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <div class="mb-8 border-b-2 border-gray-100 pb-6">
        <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Pengaturan Akun</h1>
        <p class="text-sm font-medium text-gray-600 mt-2">
            Kelola informasi profil pribadi dan keamanan kata sandi Anda di sini.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl flex items-center shadow-sm">
            <svg class="w-6 h-6 text-emerald-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="text-emerald-800 font-bold text-sm tracking-wide">
                {{ session('success') }}
            </p>
        </div>
    @endif

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
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-5">Informasi Dasar</h2>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-red-600 focus:ring-4 focus:ring-red-600/10 transition-all outline-none" 
                            required>
                        @error('name')
                            <p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-red-600 focus:ring-4 focus:ring-red-600/10 transition-all outline-none" 
                            required>
                        @error('email')
                            <p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-gray-200">

            <div>
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-gray-900">Keamanan Sandi</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">Kosongkan kolom ini jika Anda tidak ingin mengubah kata sandi.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                        <input type="password" name="new_password" placeholder="Minimal 8 karakter" 
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-red-600 focus:ring-4 focus:ring-red-600/10 transition-all outline-none">
                        @error('new_password')
                            <p class="text-xs text-red-600 font-bold mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Sandi Baru</label>
                        <input type="password" name="new_password_confirmation" placeholder="Ketik ulang kata sandi" 
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-red-600 focus:ring-4 focus:ring-red-600/10 transition-all outline-none">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-6 mt-6">
                <a href="{{ route('user.dashboard') }}"
                    class="w-full sm:w-1/3 py-4 text-center text-gray-700 font-bold text-sm border border-gray-300 rounded-xl hover:bg-gray-100 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="w-full sm:w-2/3 py-4 bg-red-600 text-white font-black uppercase text-sm tracking-widest rounded-xl hover:bg-red-700 shadow-lg shadow-red-600/30 transition-all transform hover:-translate-y-1">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection