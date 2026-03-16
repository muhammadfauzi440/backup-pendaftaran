@extends('user.dashboard')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Pengaturan Akun</h2>
        <p class="text-gray-500 font-bold mb-4 uppercase text-[10px] tracking-widest mt-2">
            Kelola informasi profil dan keamanan akun Anda
        </p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-600 rounded-r-2xl">
            <p class="text-emerald-600 font-bold text-xs uppercase tracking-widest">
                ✓ {{ session('success') }}
            </p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl">
            <p class="text-red-700 text-[10px] font-black uppercase tracking-widest mb-2"> Validasi Gagal:</p>
            <ul class="list-disc list-inside text-xs font-bold text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border-2 border-gray-50 rounded-[2.5rem] p-8 md:p-12 shadow-sm">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-3">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2"> Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                    class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-gray-900 font-bold focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all outline-none" 
                    required>
                @error('name')
                    <p class="text-xs text-red-600 font-bold ml-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                    class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-gray-900 font-bold focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all outline-none" 
                    required>
                @error('email')
                    <p class="text-xs text-red-600 font-bold ml-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="my-8 border-t-2 border-gray-100"></div>

            <div>
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Ubah Password</h3>
                <p class="text-xs text-gray-500 font-bold mb-4">Biarkan kosong jika tidak ingin mengubah password</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2">Password Baru</label>
                        <input type="password" name="new_password" placeholder="Min. 8 karakter" 
                            class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-gray-900 font-bold focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all outline-none">
                        @error('new_password')
                            <p class="text-xs text-red-600 font-bold ml-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2">Konfirmasi Password</label>
                        <input type="password" name="new_password_confirmation" placeholder="Konfirmasi password" 
                            class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-4 text-gray-900 font-bold focus:border-red-600 focus:ring-2 focus:ring-red-600/10 transition-all outline-none">
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-8">
                <a href="{{ route('user.dashboard') }}"
                    class="flex-1 py-4 text-center text-gray-600 font-black uppercase text-[10px] tracking-widest border-2 border-gray-200 rounded-2xl hover:bg-gray-50 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 py-4 bg-red-600 text-white font-black uppercase text-[10px] tracking-[0.3em] rounded-2xl hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all transform hover:-translate-y-1">
                     Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection