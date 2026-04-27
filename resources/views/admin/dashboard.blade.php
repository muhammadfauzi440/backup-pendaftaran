<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | PT Global Intermedia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/bulk-delete.js'])
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
                <span x-show="sidebarOpen" class="font-bold whitespace-nowrap">Audit Log</span>
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
                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-black text-gray-900">Dashboard Admin</h1>
                        <p class="text-gray-500 text-xs">Statistik pendaftaran magang terbaru.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="tahunFilter" class="text-sm font-semibold text-gray-700">Filter Tahun:</label>
                        <select id="tahunFilter" onchange="filterTahun(this.value)"
                            class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm font-medium text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            @foreach ($allYears as $tahun)
                                <option value="{{ $tahun }}" {{ $tahun == $selectedYear ? 'selected' : '' }}>
                                    Tahun {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-3 mb-4">
                    <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-wide">Total Peserta</p>
                        <h2 class="text-3xl font-black text-gray-900 mt-1">{{ $stats['total'] ?? 0 }}</h2>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-wide">Pending</p>
                        <h2 class="text-3xl font-black text-amber-500 mt-1">{{ $stats['pending'] ?? 0 }}</h2>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-wide">Diterima</p>
                        <h2 class="text-3xl font-black text-emerald-600 mt-1">{{ $stats['diterima'] ?? 0 }}</h2>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <p class="text-[8px] font-bold text-gray-400 uppercase tracking-wide">Ditolak</p>
                        <h2 class="text-3xl font-black text-red-600 mt-1">{{ $stats['ditolak'] ?? 0 }}</h2>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-4">
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Kategori Pendaftar</h3>
                        <div class="space-y-3">
                            @forelse($kategoriStats as $kategori => $total)
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-semibold text-gray-700">{{ $kategori }}</span>
                                        <span
                                            class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs font-bold">{{ $total }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded h-1.5">
                                        <div class="bg-blue-600 h-1.5 rounded transition-all duration-300"
                                            style="width: {{ ($total / $stats['total']) * 100 }}%"></div>
                                    </div>
                                    <div class="text-[10px] text-gray-500 mt-0.5">
                                        {{ round(($total / $stats['total']) * 100) }}%</div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center text-xs py-2">No data</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-4 col-span-2">
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Pendaftar Per Bulan (Tahun
                            {{ $selectedYear }}) - Januari hingga Desember</h3>
                        <div class="grid grid-cols-6 gap-2">
                            @php
                                $maxCount = max(array_column($monthlyChartData, 'count'));
                            @endphp
                            @forelse($monthlyChartData as $monthData)
                                <div class="text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span
                                            class="text-xs font-bold text-gray-700 h-4">{{ $monthData['label'] }}</span>
                                        <div class="w-full bg-gray-200 rounded h-16 flex items-end justify-center">
                                            <div class="bg-green-500 w-full rounded transition-all duration-300"
                                                style="height: {{ $maxCount > 0 ? ($monthData['count'] / $maxCount) * 100 : 0 }}%; min-height: 2px;">
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-900">{{ $monthData['count'] }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="col-span-6 text-gray-500 text-center text-xs py-2">No data</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-3 bg-white rounded-lg border border-gray-100 shadow-sm p-4">
                    <div class="grid grid-cols-2 gap-3">
                        @forelse($kategoriStats as $kategori => $total)
                            @php
                                $percent = $total > 0 ? round(($total / $stats['total']) * 100) : 0;
                                $colors = [
                                    'SMK' => 'bg-purple-50 text-purple-900 border-purple-200',
                                    'UNIVERSITAS' => 'bg-indigo-50 text-indigo-900 border-indigo-200',
                                ];
                                $bgColor = $colors[$kategori] ?? 'bg-gray-50 text-gray-900 border-gray-200';
                            @endphp
                            <div class="border {{ $bgColor }} rounded p-3">
                                <p class="text-xs font-semibold mb-1">{{ $kategori }}</p>
                                <div class="flex justify-between items-end">
                                    <p class="text-2xl font-black">{{ $total }}</p>
                                    <p class="text-lg font-bold">{{ $percent }}%</p>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-2 text-gray-500 text-center text-xs py-2">No data</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function filterTahun(tahun) {
            window.location.href = `{{ route('admin.dashboard') }}?tahun=${tahun}`;
        }
    </script>
</body>

</html>
