<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi | PT GI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-[#FDFDFD] font-['Plus_Jakarta_Sans']">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border-2 border-gray-50 p-10">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter mb-2">Lupa Sandi?</h1>
                <p class="text-gray-400 font-bold text-[10px] uppercase tracking-widest leading-relaxed">Masukkan email terdaftar untuk menerima tautan atur ulang sandi.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-emerald-700 text-[10px] font-bold uppercase tracking-wider">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" required
                        class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:ring-4 focus:ring-red-600/5 focus:border-red-600 focus:bg-white transition-all outline-none font-bold text-sm text-gray-900"
                        placeholder="nama@email.com">
                    @error('email')
                        <p class="text-red-600 text-[9px] font-black uppercase mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-5 bg-red-600 hover:bg-red-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] transition-all shadow-lg shadow-red-600/30 active:scale-95 transform">
                    Kirim Tautan Reset
                </button>
            </form>

            <div class="mt-10 text-center">
                <a href="{{ route('login') }}" class="text-[10px] font-black text-gray-400 hover:text-red-600 uppercase tracking-widest transition-colors">
                    &larr; Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>