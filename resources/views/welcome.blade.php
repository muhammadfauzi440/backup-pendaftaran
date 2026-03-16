<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Global Intermedia Nusantara | Technology & Innovation</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="icon" href="data:,">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cek-status.js', 'resources/js/scroll.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#FDFDFD] text-gray-900 antialiased">

    <nav class="fixed w-full z-50 top-0 border-b border-gray-100 glass-nav backdrop-blur-xl bg-white/85">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="/" class="flex items-center">
                <img src="gambar/logo_gi.png" alt="Logo GI" class="w-full h-auto">
            </a>

            <div
                class="hidden lg:flex items-center space-x-10 text-sm font-bold uppercase tracking-wider text-gray-600">
                <a href="#home" class="hover:text-red-600 transition">Beranda</a>
                <a href="#alur-magang" class="hover:text-red-600 transition">Alur Magang</a>
                <a href="#magang" class="hover:text-red-600 transition">Gabung</a>
                <a href="#contact" class="hover:text-red-600 transition">Kontak</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}"
                    class="text-sm font-bold text-gray-700 hover:text-red-600 transition">REGISTER</a>

                <a href="{{ route('login') }}"
                    class=" sm:block px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition">LOGIN</a>
            </div>
        </div>
    </nav>

    <section id="home" class="relative pt-40 pb-20 lg:pt-56 lg:pb-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center text-left">
            <div>
                <h1 class="text-5xl lg:text-6xl font-extrabold leading-[1.1] text-gray-900 mb-8">
                    Web based & <br>
                    <span class="text-red-600">Mobile App Development</span>
                </h1>

                <p class="text-lg text-gray-500 leading-relaxed mb-10 max-w-xl">
                    PT Global Intermedia Nusantara berfokus pada transformasi digital melalui pengembangan sistem
                    informasi. Kami membuka ruang bagi talenta muda untuk belajar dan berkontribusi langsung dalam
                    pengembangan ekosistem teknologi kami.
                </p>

                <div class="flex flex-wrap items-center gap-8">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-gray-900 transition-all shadow-lg shadow-red-100">
                        Ajukan Pendaftaran
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 bg-gray-50 -rotate-2"></div>
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                    class="relative rounded-2xl shadow-xl hover:grayscale-0 transition-all duration-700 border border-gray-100"
                    alt="Working at Global Intermedia">
            </div>
        </div>
    </section>

    <section id="alur-magang" class="py-24 bg-gray-50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-16">
                <h3 class="text-3xl font-black text-center text-gray-900 mb-4">Alur Pendaftaran</h3>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-10 bg-white shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-red-600 group-hover:text-white transition-all">
                        <span class="font-bold">01</span>
                    </div>
                    <h4 class="text-xl font-black mb-6 uppercase tracking-tight leading-tight text-gray-900">Registrasi
                        Akun</h4>
                    <p class="text-gray-500 text-sm font-medium italic">Buat akun untuk mendapatkan akses penuh ke
                        formulir pendaftaran.</p>
                </div>

                <div class="p-10 bg-white shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <span class="font-bold">02</span>
                    </div>
                    <h4 class="text-xl font-black mb-6 uppercase tracking-tight leading-tight text-gray-900">Lengkapi
                        Profil</h4>
                    <p class="text-gray-500 text-sm font-medium italic">Isi data diri dan pilih asal instansi sekolah
                        atau universitas.</p>
                </div>

                <div class="p-10 bg-white shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-orange-600 group-hover:text-white transition-all">
                        <span class="font-bold">03</span>
                    </div>
                    <h4 class="text-xl font-black mb-6 uppercase tracking-tight leading-tight text-gray-900">Upload
                        Berkas</h4>
                    <p class="text-gray-500 text-sm font-medium italic">Unggah CV dan Surat Pengantar resmi dari
                        instansi pendidikan.</p>
                </div>

                <div class="p-10 bg-white shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-green-600 group-hover:text-white transition-all">
                        <span class="font-bold">04</span>
                    </div>
                    <h4 class="text-xl font-black mb-6 uppercase tracking-tight leading-tight text-gray-900">Cek Status
                    </h4>
                    <p class="text-gray-500 text-sm font-medium italic">Pantau status seleksi Anda melalui dashboard
                        secara berkala.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="magang" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-gray-900 rounded-[3rem] p-8 md:p-20 text-white overflow-hidden relative shadow-2xl">
                <div class="relative z-10 max-w-2xl text-left">
                    <div
                        class="inline-block px-4 py-1 rounded-full border border-gray-700 bg-gray-800 text-xs font-bold uppercase mb-6 tracking-widest text-red-400">
                        Program Magang 2026
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black mb-6 leading-tight tracking-tight">
                        Bangun Pengalaman <span class="text-red-600">Nyata.</span>
                    </h2>
                    <p class="text-gray-400 text-lg mb-10 leading-relaxed font-medium">
                        Terbuka bagi siswa & mahasiswa untuk posisi Programmer, Designer, dan Networking di workshop
                        Yogyakarta & Bantul.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-6 items-start">
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-center">
                            Daftar Sekarang
                        </a>

                        <div class="w-full max-w-md">
                            <div class="relative group">
                                <input type="text" id="nim_nisn_input"
                                    class="w-full px-6 py-4 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-red-500 transition-all focus:bg-white/10"
                                    placeholder="Masukkan NIM atau NISN">
                                <button
                                    class="absolute right-2 top-2 bottom-2 px-6 bg-red-600 hover:bg-red-700 text-white text-[10px] font-black uppercase rounded-lg transition-all tracking-widest shadow-lg"
                                    onclick="cekStatus()">
                                    Cek Status
                                </button>
                            </div>

                            <div id="result_container"
                                class="mt-4 hidden animate-in fade-in slide-in-from-top-4 duration-500">
                                <div id="result_content"
                                    class="p-6 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-20 -bottom-20 bg-red-600/10 rounded-full blur-[100px]"></div>
            </div>
        </div>
    </section>

    <footer id="contact" class="bg-gray-50 pt-20 pb-10 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16 text-left">
                <div class="col-span-1 md:col-span-2">
                    <img src="gambar/logo_gi.png" alt="Logo GI" class="w-56 h-auto mb-8">
                    <p class="text-gray-500 text-sm leading-relaxed max-w-sm mb-6 uppercase tracking-wider font-bold">
                        PT Global Intermedia Nusantara
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-md">
                        Membantu membentuk talenta muda berbakat melalui program magang industri sejak 2004.
                    </p>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-[0.2em] mb-8 text-gray-400">Kontak</h5>
                    <ul class="space-y-4 text-sm font-bold text-gray-600">
                        <li>info@gi.co.id</li>
                        <li>+62 817-456-225</li>
                        <li>Senin - Jumat: 08.00 - 17.00</li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-[0.2em] mb-8 text-gray-400">Kantor Yogyakarta</h5>
                    <p class="text-sm font-bold text-gray-600 leading-relaxed">
                        Jl. Taman Siswa No.125, <br>
                        Wirogunan, Mergangsan, <br>
                        Kota Yogyakarta, DIY 55151
                    </p>
                </div>
            </div>
            <div
                class="pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center text-xs font-bold text-gray-400 uppercase tracking-widest gap-4">
                <p>© {{ date('Y') }} PT Global Intermedia Nusantara. All Rights Reserved.</p>
            </div>
        </div>
    </footer>


    <button id="btnBackToTop" onclick="scrollToTop()"
        class="fixed bottom-8 right-8 z-50 hidden p-4 bg-red-600 text-white rounded-full shadow-2xl hover:bg-red-700 hover:scale-110 transition-all duration-300 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:-translate-y-1 transition-transform"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
        </svg>
    </button>
</body>

</html>
