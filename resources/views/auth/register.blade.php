<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Magang | PT GI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">
</head>

<body class="bg-[#FDFDFD] font-['Plus_Jakarta_Sans'] antialiased overflow-hidden">
    <div class="min-h-screen flex items-center justify-center p-4 md:p-8">
        <div
            class="max-w-5xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100 max-h-[90vh]">

            <div
                class="md:w-5/12 bg-gray-900 p-8 md:p-10 text-white flex flex-col justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-2xl md:text-3xl font-extrabold mb-4 leading-tight">Mulai Karir Digitalmu Disini.
                    </h2>
                    <p class="text-gray-400 leading-relaxed text-sm opacity-90">
                        Silakan buat akun terlebih dahulu untuk mengakses formulir pendaftaran magang di PT Global
                        Intermedia Nusantara.
                    </p>
                </div>

                <div class="relative z-10 mt-8">
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest">© 2026 PT Global Intermedia Nusantara
                    </p>
                </div>

                <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-red-600/20 rounded-full blur-3xl"></div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl"></div>
            </div>

            <div class="md:w-7/12 p-8 md:p-10 overflow-y-auto custom-scroll">
                <div class="max-w-md mx-auto">
                    <a href="/"
                        class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 transition-all mb-6 group">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-all" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">Kembali ke Beranda</span>
                    </a>
                    <h3 class="text-xl font-black mb-2 text-gray-900 flex items-center">
                        Registrasi Akun
                    </h3>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-600 rounded-r-xl text-xs">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/register') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 ml-1">Nama
                                Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-3.5 bg-gray-50 border rounded-xl outline-none transition focus:ring-2 
                                {{ $errors->has('name') ? 'border-red-500 focus:ring-red-500' : 'border-gray-100 focus:ring-red-600/20 focus:border-red-600' }}"
                                placeholder="Masukkan nama" required autocomplete="name">
                        </div>

                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 ml-1">Email
                                (Username)</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3.5 bg-gray-50 border rounded-xl outline-none transition focus:ring-2 
                                {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500' : 'border-gray-100 focus:ring-red-600/20 focus:border-red-600' }}"
                                placeholder="Masukkan email" required autocomplete="email">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-gray-400 ml-1">Password</label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-3.5 bg-gray-50 border rounded-xl outline-none transition focus:ring-2 
                                    {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : 'border-gray-100 focus:ring-red-600/20 focus:border-red-600' }}"
                                    placeholder="••••••••" required autocomplete="new-password">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-gray-400 ml-1">Konfirmasi</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-3.5 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-red-600/20 focus:border-red-600 outline-none transition"
                                    placeholder="••••••••" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-4 bg-red-600 text-white text-sm font-black rounded-xl hover:bg-red-700 shadow-lg shadow-red-600/30 transition-all transform hover:-translate-y-0.5 active:scale-[0.98]">
                                BUAT AKUN SEKARANG
                            </button>
                        </div>
                    </form>

                    <p class="mt-4 text-center text-xs text-gray-500">
                        Sudah punya akun? <a href="{{ route('login') }}"
                            class="text-red-600 font-bold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
