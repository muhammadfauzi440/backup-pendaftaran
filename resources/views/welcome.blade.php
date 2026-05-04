<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Global Intermedia Nusantara | Technology & Innovation</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="data:,">
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/scroll.js'
    ])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#FDFDFD] text-gray-900 antialiased overflow-x-hidden">

    <!-- NAVBAR -->
    <nav class="fixed w-full z-50 top-0 border-b border-gray-100 glass-nav backdrop-blur-xl bg-white/85">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="/" class="flex items-center">
                <!-- Pastikan path gambar logo sesuai dengan struktur folder Anda -->
                <img src="gambar/logo_gi.png" alt="Logo GI" class="h-auto md:h-auto w-full">
            </a>

            <div class="hidden lg:flex items-center space-x-10 text-sm font-bold uppercase tracking-wider text-gray-600">
                <a href="#home" class="hover:text-red-600 transition">Beranda</a>
                <a href="#alur-magang" class="hover:text-red-600 transition">Alur Magang</a>
                <a href="#gabung" class="hover:text-red-600 transition">Gabung</a>
                <a href="#contact" class="hover:text-red-600 transition">Kontak</a>
            </div>

            <div class="flex items-center gap-4">
                <!-- Rute Baru ke Halaman Cek Status -->
                <a href="{{ route('cek-status.index') }}" class="hidden md:block text-sm font-bold text-gray-500 hover:text-red-600 transition">Cek Status</a>
                <a href="{{ route('register') }}" class="text-sm font-bold text-gray-700 hover:text-red-600 transition">Daftar</a>
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition">Login</a>
            </div>
        </div>
    </nav>

    <!-- SECTION 1: HERO -->
    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center text-left">
            <div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.1] text-gray-900 mb-6 lg:mb-8 tracking-tight">
                    Web based & <br>
                    <span class="text-red-600">Mobile App Development</span>
                </h1>

                <p class="text-base sm:text-lg text-gray-500 leading-relaxed mb-8 lg:mb-10 max-w-xl">
                    PT Global Intermedia Nusantara berfokus pada transformasi digital melalui pengembangan sistem
                    informasi. Kami membuka ruang bagi talenta muda untuk belajar dan berkontribusi langsung dalam
                    pengembangan ekosistem teknologi kami.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-600/20 text-center">
                        Ajukan Pendaftaran
                    </a>
                    <a href="{{ route('cek-status.index') }}" class="w-full sm:w-auto px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all border border-gray-200 text-center">
                        Cek Status Saya
                    </a>
                </div>
            </div>

            <div class="relative hidden sm:block">
                <div class="absolute -inset-4 bg-gray-50 rounded-2xl -rotate-2"></div>
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                    class="relative rounded-2xl shadow-xl border border-gray-100 w-full object-cover"
                    alt="Working at Global Intermedia">
            </div>
        </div>
    </section>

    <!-- SECTION 2: ALUR MAGANG -->
    <section id="alur-magang" class="py-20 lg:py-24 bg-gray-50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12 lg:mb-16 text-center lg:text-left">
                <h3 class="text-3xl font-black text-gray-900 mb-4">Alur Pendaftaran</h3>
                <p class="text-gray-500 max-w-2xl mx-auto lg:mx-0">Ikuti langkah-langkah mudah berikut untuk bergabung dengan program magang kami.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div class="p-8 bg-white shadow-sm hover:shadow-xl transition-all border border-gray-100 rounded-3xl group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="text-6xl font-black">01</span>
                    </div>
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <h4 class="text-lg font-black mb-3 uppercase tracking-tight text-gray-900 relative z-10">Registrasi Akun</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed relative z-10">Buat akun untuk mendapatkan akses ke dashboard dan formulir pendaftaran.</p>
                </div>

                <div class="p-8 bg-white shadow-sm hover:shadow-xl transition-all border border-gray-100 rounded-3xl group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="text-6xl font-black">02</span>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-lg font-black mb-3 uppercase tracking-tight text-gray-900 relative z-10">Lengkapi Profil</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed relative z-10">Isi biodata lengkap, pilih tipe magang, dan tentukan asal instansi Anda.</p>
                </div>

                <div class="p-8 bg-white shadow-sm hover:shadow-xl transition-all border border-gray-100 rounded-3xl group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="text-6xl font-black">03</span>
                    </div>
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <h4 class="text-lg font-black mb-3 uppercase tracking-tight text-gray-900 relative z-10">Upload Berkas</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed relative z-10">Unggah dokumen pelengkap seperti CV dan Surat Pengantar resmi instansi.</p>
                </div>

                <div class="p-8 bg-white shadow-sm hover:shadow-xl transition-all border border-gray-100 rounded-3xl group relative overflow-hidden">
                     <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="text-6xl font-black">04</span>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-lg font-black mb-3 uppercase tracking-tight text-gray-900 relative z-10">Cek Status</h4>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed relative z-10">Gunakan kode pendaftaran unik untuk memantau status persetujuan magang.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: CALL TO ACTION (GABUNG) -->
    <section id="gabung" class="py-20 lg:py-24 bg-white relative overflow-hidden">
        <!-- Dekorasi Background -->
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_top_right,var(--tw-gradient-stops))] from-gray-100 via-white to-white opacity-60"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="bg-gray-900 rounded-[2.5rem] lg:rounded-[3rem] p-8 sm:p-12 lg:p-20 text-white shadow-2xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-12">
                
                <!-- Lingkaran Dekorasi -->
                <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-red-600 rounded-full filter blur-[100px] opacity-30"></div>
                
                <div class="max-w-2xl text-center lg:text-left z-10">
                    <div class="inline-block px-4 py-1.5 rounded-full border border-gray-700 bg-gray-800 text-[10px] sm:text-xs font-black uppercase mb-6 tracking-[0.2em] text-red-400 shadow-sm">
                        Program Magang {{ date('Y') }}
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-black mb-6 leading-tight tracking-tight text-white">
                        Bangun Pengalaman <br class="hidden sm:block"><span class="text-red-500">Dunia Nyata.</span>
                    </h2>
                    <p class="text-gray-400 text-base sm:text-lg mb-0 leading-relaxed font-medium">
                        Dapatkan bimbingan mentor profesional dan rasakan budaya kerja yang inovatif. Terbuka bagi siswa SMK & Mahasiswa.
                    </p>
                </div>

                <div class="z-10 w-full lg:w-auto shrink-0 flex flex-col gap-4">
                    <a href="{{ route('register') }}" class="w-full lg:w-64 px-8 py-5 bg-red-600 text-white font-black text-sm uppercase tracking-widest rounded-2xl hover:bg-red-500 transition-all shadow-xl shadow-red-600/30 text-center transform hover:-translate-y-1">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="w-full lg:w-64 px-8 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-black text-sm uppercase tracking-widest rounded-2xl hover:bg-white/20 transition-all text-center">
                        Login Akun
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="contact" class="bg-white pt-20 pb-10 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16 text-left">
                <div class="col-span-1 md:col-span-2">
                    <img src="gambar/logo_gi.png" alt="Logo GI" class="w-48 h-auto mb-6">
                    <p class="text-gray-900 text-xs font-black uppercase tracking-[0.2em] mb-4">
                        PT Global Intermedia Nusantara
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-md">
                        Membantu membentuk talenta muda berbakat melalui program magang industri dan pengembangan IT terpadu.
                    </p>
                </div>
                
                <div>
                    <h5 class="font-black text-[10px] uppercase tracking-[0.2em] mb-6 text-gray-400">Kontak Kami</h5>
                    <ul class="space-y-4 text-sm font-bold text-gray-700">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            info@gi.co.id
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 817-456-225
                        </li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-black text-[10px] uppercase tracking-[0.2em] mb-6 text-gray-400">Kantor Yogyakarta</h5>
                    <p class="text-sm font-bold text-gray-700 leading-relaxed">
                        Jl. Taman Siswa No.125, <br>
                        Wirogunan, Mergangsan, <br>
                        Kota Yogyakarta, DIY 55151
                    </p>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center sm:text-left">
                    © {{ date('Y') }} PT Global Intermedia Nusantara. All Rights Reserved.
                </p>
                <div class="flex gap-4">
                    <!-- Tautan Sosmed Opsional -->
                    <a href="#" class="text-gray-400 hover:text-gray-900 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-gray-400 hover:text-gray-900 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                    <a href="#" class="text-gray-400 hover:text-gray-900 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCROLL TO TOP BUTTON -->
    <button id="btnBackToTop" onclick="scrollToTop()"
        class="fixed bottom-8 right-8 z-50 hidden p-4 bg-red-600 text-white rounded-full shadow-xl hover:bg-red-700 hover:scale-110 transition-all duration-300 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:-translate-y-1 transition-transform"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
        </svg>
    </button>
</body>

</html>