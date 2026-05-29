<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cek Status Pendaftaran | PT Global Intermedia</title>
    @vite(['resources/css/app.css', 'resources/js/cek-status.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50/50 font-['Plus_Jakarta_Sans'] min-h-screen flex flex-col items-center justify-center p-4 antialiased">

    <div class="w-full max-w-md">
        <a href="/" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-medium text-sm mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sm:p-8">
            <div class="flex flex-col space-y-1.5 mb-6">
                <h3 class="font-semibold tracking-tight text-2xl text-slate-900">Cek Status</h3>
                <p class="text-sm text-slate-500">Masukkan kode pendaftaran unik Anda untuk melihat status saat ini.</p>
            </div>

            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" id="kode_input"
                        class="flex h-10 w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-red-600 uppercase"
                        placeholder="Contoh: GIN-12345">
                    <button
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-red-600 disabled:pointer-events-none disabled:opacity-50 bg-red-600 text-white shadow hover:bg-red-600/90 h-10 px-4 py-2 sm:w-auto w-full"
                        onclick="cekStatus()">
                        Cek Status
                    </button>
                </div>
            </div>

            <div id="result_container" class="hidden mt-6 pt-6 border-t border-slate-100">
                <div id="result_content" class="text-sm"></div>
            </div>
        </div>
    </div>
</body>
</html>