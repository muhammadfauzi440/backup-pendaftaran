<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Sandi | PT GI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-[#FDFDFD] font-['Plus_Jakarta_Sans']">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border-2 border-gray-50 p-10">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter mb-2">Reset Sandi</h1>
                <p class="text-gray-400 font-bold text-[10px] uppercase tracking-widest leading-relaxed">Silakan buat kata sandi baru untuk mengamankan akun Anda.</p>
            </div>
            
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-red-700 text-[10px] font-bold uppercase tracking-wider">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Kata Sandi Baru</label>
                    <input type="password" name="password" required
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:ring-4 focus:ring-red-600/5 focus:border-red-600 focus:bg-white transition-all outline-none font-bold text-sm text-gray-900"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-600 text-[9px] font-black uppercase mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Konfirmasi Sandi Baru</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:ring-4 focus:ring-red-600/5 focus:border-red-600 focus:bg-white transition-all outline-none font-bold text-sm text-gray-900"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="w-full py-5 bg-gray-900 hover:bg-black text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] transition-all shadow-lg active:scale-95 transform">
                    Perbarui Kata Sandi
                </button>
            </form>
        </div>
    </div>
</body>
</html>