<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cek Status Pendaftaran | PT Global Intermedia</title>
    @vite(['resources/css/app.css', 'resources/js/cek-status.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-['Plus_Jakarta_Sans'] min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden">

    <div class="w-full max-w-md relative z-10">
        <!-- Tombol Kembali -->
        <a href="/" class="inline-flex items-center gap-2 text-gray-500 hover:text-red-600 font-bold text-sm mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>

        <!-- Card Utama -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mb-6 border border-red-100">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Cek Status</h1>
            <p class="text-gray-500 font-medium text-sm mb-8">Masukkan kode pendaftaran unik yang Anda dapatkan setelah mendaftar.</p>

            <!-- Input & Tombol -->
            <div class="relative group mb-6">
                <input type="text" id="kode_input"
                    class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl text-gray-900 text-sm font-bold uppercase tracking-widest focus:outline-none focus:border-red-600 focus:bg-white transition-all shadow-inner"
                    placeholder="CONTOH: GIN-12345">
                <button
                    class="absolute right-2 top-2 bottom-2 px-6 bg-red-600 hover:bg-red-700 text-white text-[10px] font-black uppercase rounded-xl transition-all tracking-widest shadow-md transform hover:-translate-y-0.5"
                    onclick="cekStatus()">
                    Cek Status
                </button>
            </div>

            <!-- Menampilkan Hasil -->
            <div id="result_container" class="hidden">
                <div id="result_content" class="p-6 rounded-2xl bg-gray-50 border border-gray-100"></div>
            </div>
        </div>
    </div>
</body>
</html>