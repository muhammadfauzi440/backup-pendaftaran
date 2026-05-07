@extends('admin.dashboard')

@section('content')
    <div class="max-w-3xl mx-auto py-6">

        {{-- Header --}}
        <div class="mb-8 border-b-2 border-gray-100 pb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.users.index') }}"
                    class="text-gray-400 hover:text-gray-900 transition-colors p-2 hover:bg-gray-100 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Tambah Akun Baru</h1>
                    <p class="text-sm font-medium text-gray-500 mt-2">Buat akun user atau admin baru untuk mengakses sistem.</p>
                </div>
            </div>
        </div>

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="mb-8 p-5 bg-red-50 border-l-4 border-red-600 rounded-r-xl shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-800 text-sm font-black uppercase tracking-wide">Gagal Membuat Akun</p>
                </div>
                <ul class="list-disc list-inside text-sm font-semibold text-red-700 space-y-1 ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <div class="bg-white border border-gray-200 rounded-3xl p-8 md:p-10 shadow-sm">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all outline-none"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="email@example.com"
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all outline-none"
                        required>
                </div>

                <hr class="border-gray-200">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Kata Sandi <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password"
                            placeholder="Minimal 6 karakter"
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-gray-900 font-semibold focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all outline-none"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Role Akses <span class="text-red-500">*</span>
                        </label>
                        <select name="role"
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-5 py-3.5 text-red-600 font-semibold focus:bg-white focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all outline-none appearance-none">
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User (Pendaftar)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4 mt-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="w-full sm:w-1/3 py-4 text-center font-bold text-sm bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-2/3 py-4 bg-gray-900 text-white font-black uppercase text-sm tracking-widest rounded-xl hover:bg-black shadow-lg shadow-gray-900/30 transition-all transform hover:-translate-y-0.5">
                        Buat Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
