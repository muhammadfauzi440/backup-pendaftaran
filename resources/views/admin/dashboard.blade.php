<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | PT Global Intermedia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/bulk-delete.js', 'resources/js/stats.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50 font-['Plus_Jakarta_Sans']" x-data="{ sidebarOpen: $persist(true) }">

    <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
        class="fixed left-0 top-0 h-screen bg-gray-900 text-white transition-all duration-300 z-50">
        <div class="p-6 flex items-center gap-4 border-b border-gray-800 justify-center">
            <span x-show="sidebarOpen" class="font-bold text-lg whitespace-nowrap">Admin <span
                    class="text-red-600">Dashboard</span></span>
        </div>

        <nav class="mt-8 px-4 space-y-2 flex flex-col h-[calc(100vh-120px)]">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-4 px-4 py-3 {{ Request::is('admin/dashboard') ? 'bg-red-600' : 'text-gray-400 hover:bg-gray-800' }} rounded-xl transition">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span x-show="sidebarOpen" class="font-bold whitespace-nowrap">Dashboard</span>
            </a>

            <a href="{{ route('admin.pendaftaran.index') }}"
                class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-gray-800' }} rounded-xl transition">

                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.pendaftaran.*') ? 'text-white' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>

                <span x-show="sidebarOpen" class="font-bold whitespace-nowrap">Data Pendaftar</span>
            </a>

            <a href="{{ route('admin.instansi.index') }}"
                class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('admin.instansi.*') ? 'bg-red-600' : 'text-gray-400' }} rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span x-show="sidebarOpen" class="font-bold">Data Instansi</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.users.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-white/5' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span x-show="sidebarOpen" class="font-bold whitespace-nowrap">Akun</span>
            </a>

            <a href="{{ route('admin.audit-logs.index') }}"
                class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('admin.audit-logs.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-gray-800' }} rounded-xl transition">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.audit-logs.*') ? 'text-white' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span x-show="sidebarOpen" class="font-bold whitespace-nowrap">Log</span>
            </a>


            <form action="{{ route('logout') }}" method="POST" class="pb-6">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-4 px-4 py-3 text-red-500 hover:bg-red-500/10 rounded-xl transition group cursor-pointer">
                    <svg class="w-5 h-5 shrink-0 group-hover:scale-110 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen"
                        class="font-black text-xs uppercase tracking-[0.2em] whitespace-nowrap">Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <div :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="transition-all duration-300">
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-gray-50 rounded-lg text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </header>

        <div class="p-4 pb-6 overflow-y-auto" style="height: calc(100vh - 80px);">
            @hasSection('content')
                @yield('content')
            @else
                <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Dashboard Admin</h1>
                        <p class="text-gray-500 text-sm font-medium mt-1">Ringkasan analitik pendaftaran magang PT
                            Global Intermedia.</p>
                    </div>
                    <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-gray-200 shadow-sm">
                        <label for="tahunFilter"
                            class="text-xs font-bold text-gray-500 uppercase tracking-wider pl-2">Tahun:</label>
                        <select id="tahunFilter" onchange="filterTahun(this.value)"
                            class="px-4 py-2 border-none rounded-lg bg-gray-50 text-sm font-bold text-gray-900 focus:ring-0 cursor-pointer outline-none hover:bg-gray-100 transition-colors">
                            @foreach ($allYears as $tahun)
                                <option value="{{ $tahun }}" {{ $tahun == $selectedYear ? 'selected' : '' }}>
                                    {{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                    <div
                        class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest relative z-10">Total
                            Pendaftar</p>
                        <h2 class="text-4xl font-black text-gray-900 mt-2 relative z-10">{{ $stats['total'] ?? 0 }}
                        </h2>
                    </div>

                    <div
                        class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full opacity-50"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest relative z-10">Status
                            Pending</p>
                        <h2 class="text-4xl font-black text-amber-500 mt-2 relative z-10">{{ $stats['pending'] ?? 0 }}
                        </h2>
                    </div>

                    <div
                        class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest relative z-10">Lolos
                            Diterima</p>
                        <h2 class="text-4xl font-black text-emerald-600 mt-2 relative z-10">
                            {{ $stats['diterima'] ?? 0 }}</h2>
                    </div>

                    <div
                        class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-50 rounded-full opacity-50"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest relative z-10">Ditolak
                        </p>
                        <h2 class="text-4xl font-black text-red-600 mt-2 relative z-10">{{ $stats['ditolak'] ?? 0 }}
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div
                        class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-6 min-w-0 overflow-hidden">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-2">Statistik Bulanan
                            {{ $selectedYear }}</h3>
                        <p class="text-xs text-gray-500 font-medium mb-4">Statistik pendaftar masuk dari bulan Januari
                            hingga Desember.</p>
                        <div id="monthlyChart" class="w-full" style="min-height: 300px;"></div>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 min-w-0 overflow-hidden">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-2">Asal Instansi</h3>
                        <p class="text-xs text-gray-500 font-medium mb-4">Data Pendaftar berdasarkan kategori
                            sekolah/kampus.</p>
                        <div id="kategoriChart" class="w-full flex justify-center items-center mt-8"
                            style="min-height: 250px;"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        window.dashboardData = {
            filterRoute: "{{ route('admin.dashboard') }}",
            monthlyData: {!! json_encode(array_column($monthlyChartData ?? [], 'count')) !!},
            monthlyLabels: {!! json_encode(array_column($monthlyChartData ?? [], 'label')) !!},
            kategoriLabels: {!! json_encode(array_keys($kategoriStats ?? [])) !!},
            kategoriData: {!! json_encode(array_values($kategoriStats ?? [])) !!}
        }
    </script>
</body>

</html>
