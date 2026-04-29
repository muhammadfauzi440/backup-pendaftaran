<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | PT GI</title>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/daftar.js',
        'resources/js/kelompok.js',
        'resources/js/copy.js'
    ])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#FDFDFD] font-['Plus_Jakarta_Sans'] overflow-x-hidden" x-data="{ sidebarOpen: window.innerWidth >= 768 }">
    
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
        class="fixed inset-0 z-55 bg-gray-900/50 backdrop-blur-sm md:hidden" aria-hidden="true" style="display: none;">
    </div>

    <div class="flex min-h-screen w-full">

        <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full md:translate-x-0 md:w-20'"
            class="fixed left-0 top-0 h-screen bg-gray-900 text-white transition-all duration-300 z-60 overflow-hidden flex flex-col">
            
            <div class="p-6 flex items-center justify-between border-b border-gray-800 h-20">
                <span x-show="sidebarOpen" class="font-bold text-lg whitespace-nowrap">User <span
                        class="text-red-600">Dashboard</span></span>
                <span x-show="!sidebarOpen" class="font-black text-xl tracking-tight hidden md:block w-full text-center text-red-600">GI</span>
                
                <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="mt-8 px-4 space-y-2 flex flex-col h-[calc(100vh-120px)] overflow-y-auto overflow-x-hidden">
                <a href="{{ route('user.dashboard') }}"
                    class="flex items-center gap-4 px-4 py-3 {{ Request::is('user/dashboard') ? 'bg-white/10 text-white font-bold' : 'text-gray-400 hover:text-white hover:bg-white/5' }} rounded-xl transition" title="Dashboard">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="text-sm font-bold tracking-wide whitespace-nowrap">DASHBOARD</span>
                </a>

                <a href="/user/daftar"
                    class="flex items-center gap-4 px-4 py-3 {{ Request::is('user/daftar*') ? 'bg-white/10 text-white font-bold' : 'text-gray-400 hover:text-white hover:bg-white/5' }} rounded-xl transition" title="Pendaftaran">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="text-sm font-bold tracking-wide whitespace-nowrap">PENDAFTARAN</span>
                </a>

                <a href="{{ route('profile.index') }}"
                    class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('profile.*') ? 'bg-white/10 text-white font-bold' : 'text-gray-400 hover:text-white hover:bg-white/5' }} rounded-xl transition" title="Akun">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span x-show="sidebarOpen" class="text-sm font-bold tracking-wide whitespace-nowrap">AKUN</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="pt-4 mt-auto pb-6">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-4 px-4 py-4 bg-red-600 hover:bg-red-700 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-lg shadow-red-900/20 transition-all transform hover:-translate-y-1 group" title="Keluar Akun">
                        <svg class="w-4 h-4 shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span x-show="sidebarOpen" class="whitespace-nowrap">KELUAR AKUN</span>
                    </button>
                </form>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col transition-all duration-300 w-full max-w-full" :class="sidebarOpen ? 'md:ml-64' : 'md:ml-20'">
            
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-40 shadow-sm md:shadow-none">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 -ml-2 hover:bg-gray-50 rounded-lg text-gray-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <span class="md:hidden font-bold text-gray-900">User Panel</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-black text-gray-900 leading-none">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center font-black border-2 border-white shadow-sm uppercase">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-12 overflow-x-hidden relative z-0">
                @hasSection('content')
                    @yield('content')
                @else
                    <div class="max-w-5xl mx-auto">
                        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 mb-2 uppercase tracking-tighter italic">Halo,
                            {{ auth()->user()->name }}! 👋</h1>
                        <p class="text-gray-500 mb-10 text-sm sm:text-lg">Selamat datang di portal magang PT Global Intermedia
                            Nusantara.</p>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-8">

                            <div class="md:col-span-3 bg-white border-2 border-gray-50 p-6 sm:p-8 rounded-3xl sm:rounded-[2.5rem] shadow-sm overflow-hidden">
                                <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Status
                                    Pendaftaran Anda</h2>

                                @if (isset($pendaftaran) && $pendaftaran)
                                    <div
                                        class="inline-flex items-center px-6 py-2 rounded-full mb-6 font-black uppercase tracking-widest text-[10px]
                                        {{ $pendaftaran->status == 'pending' ? 'bg-amber-50 text-amber-600' : '' }}
                                        {{ $pendaftaran->status == 'diterima' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                        {{ $pendaftaran->status == 'ditolak' ? 'bg-red-50 text-red-600' : '' }}">
                                        ● STATUS: {{ $pendaftaran->status }}
                                    </div>

                                    @if ($pendaftaran->status == 'diterima')
                                        <div class="mt-2 mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-sm">
                                            <div>
                                                <h3 class="text-emerald-800 font-black text-sm uppercase tracking-widest">Selamat! Anda Diterima</h3>
                                                <p class="text-emerald-600 text-[10px] font-bold mt-1">Unduh Surat Balasan/LoA untuk diserahkan ke instansi Anda.</p>
                                            </div>
                                            <a href="{{ route('user.cetak-surat') }}" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-600/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download PDF
                                            </a>
                                        </div>
                                    @endif
                                    

                                    <div class="mb-6 p-4 sm:p-5 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl flex justify-between items-center group hover:border-red-300 transition-colors">
                                        <div class="min-w-0 pr-2">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Kode Pendaftaran</span>
                                            <span class="text-xl sm:text-2xl font-black text-gray-900 tracking-widest truncate block" id="kode-pendaftaran">{{ $pendaftaran->kode_pendaftaran ?? '-' }}</span>
                                        </div>
                                        <button id="btn-copy-kode"
                                            class="shrink-0 p-3 bg-white border border-gray-200 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all shadow-sm text-gray-500 flex items-center gap-2"
                                            title="Salin Kode Pendaftaran">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="text-[10px] font-bold uppercase tracking-widest hidden sm:block">Salin</span>
                                        </button>
                                    </div>

                                    <div class="space-y-4 mt-2">
                                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-50 pb-3 sm:items-end gap-1">
                                            <span class="text-gray-400 text-xs font-bold uppercase">Nama Pendaftar / Ketua</span>
                                            <span class="text-gray-900 font-black text-sm">{{ $pendaftaran->user->name ?? '-' }}</span>
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-50 pb-3 sm:items-end gap-1">
                                            <span class="text-gray-400 text-xs font-bold uppercase">Tipe Pendaftaran</span>
                                            <span class="text-gray-900 font-black text-sm uppercase">{{ $pendaftaran->tipe_pendaftaran ?? '-' }}</span>
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-50 pb-3 sm:items-end gap-1">
                                            <span class="text-gray-400 text-xs font-bold uppercase">Instansi / Kampus</span>
                                            <span class="text-gray-900 font-black text-sm text-left sm:text-right">{{ $pendaftaran->instansi->nama_instansi ?? '-' }}</span>
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-gray-50 pb-3 sm:items-center gap-2">
                                            <span class="text-gray-400 text-xs font-bold uppercase">Periode Magang</span>
                                            <div class="text-left sm:text-right">
                                                <span class="text-gray-900 font-black text-sm block mb-1">
                                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->format('d M Y') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)->format('d M Y') }}
                                                </span>
                                                <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider inline-block mt-1">
                                                    Durasi: {{ $pendaftaran->durasi_bulan ?? 0 }} Bulan
                                                </span>
                                            </div>
                                        </div>

                                        <div class="pt-6">
                                            @can('update', $pendaftaran)
                                                <a href="/user/daftar" class="block text-center sm:inline-block bg-red-600 text-white px-8 py-4 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-red-700 transition-all shadow-xl shadow-red-600/20 transform hover:-translate-y-1">
                                                    Edit / Lihat Formulir &rarr;
                                                </a>
                                            @else   
                                                <button disabled class="w-full sm:w-auto bg-gray-200 text-gray-500 cursor-not-allowed px-8 py-4 rounded-2xl text-xs font-black uppercase tracking-[0.2rem] shadow-sm">
                                                    Formulir Terkunci (Diproses/Selesai)
                                                </button>
                                                <p class="text-xs font-bold text-gray-400 mt-3 text-center sm:text-left">
                                                    *Anda tidak dapat lagi mengubah data pendaftaran karena status sudah bukan "Pending"
                                                </p>
                                            @endcan
                                        </div>
                                    </div>
                                @else
                                    <div class="py-10 text-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 mb-8 font-medium text-sm">Anda belum mengisi formulir pendaftaran magang.</p>
                                        <a href="/user/daftar" class="inline-block bg-gray-900 text-white px-10 py-4 rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-red-600 transition shadow-xl shadow-gray-200">
                                            Daftar Sekarang
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="md:col-span-2 bg-gray-900 p-6 sm:p-8 rounded-3xl sm:rounded-[2.5rem] shadow-2xl text-white flex flex-col justify-between relative overflow-hidden group">
                                <div class="absolute -right-6 -top-6 opacity-5 group-hover:opacity-10 transition-opacity duration-500 transform rotate-12">
                                </div>

                                <div class="relative z-10">
                                    <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-red-600/40">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-12 h-12 text-white">
                                            <path d="M320 128C241 128 175.3 185.3 162.3 260.7C171.6 257.7 181.6 256 192 256L208 256C234.5 256 256 277.5 256 304L256 400C256 426.5 234.5 448 208 448L192 448C139 448 96 405 96 352L96 288C96 164.3 196.3 64 320 64C443.7 64 544 164.3 544 288L544 456.1C544 522.4 490.2 576.1 423.9 576.1L336 576L304 576C277.5 576 256 554.5 256 528C256 501.5 277.5 480 304 480L336 480C362.5 480 384 501.5 384 528L384 528L424 528C463.8 528 496 495.8 496 456L496 435.1C481.9 443.3 465.5 447.9 448 447.9L432 447.9C405.5 447.9 384 426.4 384 399.9L384 303.9C384 277.4 405.5 255.9 432 255.9L448 255.9C458.4 255.9 468.3 257.5 477.7 260.6C464.7 185.3 399.1 127.9 320 127.9z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Pusat Bantuan</h2>
                                    <p class="text-sm leading-relaxed text-gray-300 mb-8 font-medium">Jika Anda
                                        mengalami kendala saat mendaftar atau memiliki pertanyaan mengenai proses
                                        seleksi magang,<br> <span class="font-bold text-red-600">Admin</span> siap
                                        membantu Anda.</p>
                                </div>

                                <a href="https://wa.me/6287782521039" target="_blank"
                                    class="relative z-10 w-full text-center inline-flex items-center justify-center gap-3 bg-white text-gray-900 py-4 px-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-red-600 hover:text-white transition-all shadow-xl">
                                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.944 0A12 12 0 000 12a12 12 0 003.537 8.528L2 24l3.666-1.155A11.95 11.95 0 0011.944 24c6.627 0 12-5.373 12-12S18.571 0 11.944 0zM12 21.823a9.78 9.78 0 01-4.992-1.353l-.358-.212-2.484.783.664-2.424-.233-.37A9.78 9.78 0 012.18 12c0-5.414 4.406-9.82 9.82-9.82 5.414 0 9.82 4.406 9.82 9.82 0 5.414-4.406 9.82-9.82 9.82zm5.385-7.348c-.295-.148-1.745-.862-2.015-.96-.27-.099-.467-.148-.664.148-.196.296-.761.961-.933 1.158-.172.197-.344.222-.64.074-.295-.148-1.245-.458-2.37-1.295-.875-.652-1.465-1.458-1.637-1.754-.172-.296-.018-.456.13-.604.133-.133.295-.345.443-.518.148-.173.196-.296.295-.494.099-.197.049-.37-.024-.518-.074-.148-.664-1.601-.909-2.193-.241-.578-.485-.5-.664-.509-.172-.009-.37-.009-.567-.009-.196 0-.516.074-.787.37-.27.296-1.033 1.011-1.033 2.466 0 1.455 1.057 2.862 1.205 3.06.148.197 2.087 3.183 5.053 4.461.705.302 1.255.482 1.684.617.708.224 1.352.192 1.86.116.571-.085 1.745-.713 1.991-1.403.246-.69.246-1.282.172-1.403-.074-.123-.27-.197-.565-.345z" />
                                    </svg>
                                    <span>Chat Admin</span>
                                </a>
                            </div>

                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL',
                text: "{{ session('success') }}",
                confirmButtonColor: '#111827',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl uppercase font-black tracking-widest text-xs py-3 px-6'
                }
            });
        </script>
    @endif
</body>

</html>