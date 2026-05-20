@extends('user.dashboard')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Formulir Pendaftaran Magang</h1>
            <p class="text-gray-500">Silahkan lengkapi seluruh data sesuai dengan kartu identitas dan dokumen asli.</p>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-600 p-6 mb-6 rounded-r-2xl shadow-sm animate-pulse">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h4 class="font-black text-red-800 uppercase text-sm tracking-widest">Pendaftaran Gagal Disubmit!</h4>
                </div>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-1 font-medium ml-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.daftar.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div>
                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tipe Pendaftaran</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="tipe_pendaftaran" value="individu" class="peer hidden"
                            {{ $tipe == 'individu' ? 'checked' : '' }}
                            onclick="window.location.href='{{ route('user.daftar', ['tipe' => 'individu']) }}'">
                        <div
                            class="px-6 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 font-bold transition">
                            Individu
                        </div>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="tipe_pendaftaran" value="kelompok" class="peer hidden"
                            {{ $tipe == 'kelompok' ? 'checked' : '' }}
                            onclick="window.location.href='{{ route('user.daftar', ['tipe' => 'kelompok']) }}'">
                        <div
                            class="px-6 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 font-bold transition">
                            Kelompok
                        </div>
                    </label>
                </div>
            </div>

            <div class="bg-white border-2 border-gray-100 p-8 rounded-3xl shadow-sm">
                <div class="flex items-center gap-3 mb-8 border-b-2 border-gray-50 pb-4">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">01
                    </div>
                    <h3 class="text-lg font-black text-gray-900 uppercase">Informasi Magang</h3>
                </div>

                {{-- Script untuk logika custom dropdown instansi --}}
                <script>
                    function instansiDropdown() {
                        return {
                            open: false,
                            mode: 'pilih',
                            search: '',
                            selectedLabel: '-- Pilih Instansi --',
                            selectedValue: '{{ old('instansi_id', $pendaftaran?->instansi_id ?? '') }}',
                            isLainSelected: {{ (old('instansi_id') === 'lain' || (!old('instansi_id') && $pendaftaran?->instansi_lain)) ? 'true' : 'false' }},
                            instansis: @json($instansis->map(fn($i) => ['id' => (string)$i->id, 'label' => $i->nama_instansi . ' (' . strtoupper($i->tipe) . ')'])),

                            init() {
                                if (this.isLainSelected) {
                                    this.mode = 'lain';
                                    this.selectedValue = 'lain';
                                    this.selectedLabel = 'Instansi lain (tidak ada dalam daftar)';
                                } else if (this.selectedValue) {
                                    const found = this.instansis.find(i => i.id === String(this.selectedValue));
                                    if (found) this.selectedLabel = found.label;
                                }
                            },

                            get filtered() {
                                if (!this.search.trim()) return this.instansis;
                                const q = this.search.toLowerCase();
                                return this.instansis.filter(i => i.label.toLowerCase().includes(q));
                            },

                            selectInstansi(id, label) {
                                this.selectedValue = id;
                                this.selectedLabel = label;
                                this.mode = 'pilih';
                                this.open = false;
                                this.search = '';
                            },

                            selectLain() {
                                this.selectedValue = 'lain';
                                this.selectedLabel = 'Instansi lain (tidak ada dalam daftar)';
                                this.mode = 'lain';
                                this.open = false;
                                this.search = '';
                            }
                        };
                    }
                </script>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 relative" x-data="instansiDropdown()" @click.outside="open = false">

                        <label class="block text-sm font-black text-gray-700 uppercase mb-2">Asal Instansi / Sekolah</label>

                        {{-- Hidden input untuk submit form --}}
                        <input type="hidden" name="instansi_id" :value="selectedValue">

                        {{-- Trigger Button --}}
                        <button type="button"
                            id="instansi-dropdown-trigger"
                            @click="open = !open"
                            class="w-full border-2 rounded-xl px-5 py-4 text-left text-sm font-semibold flex items-center justify-between gap-3 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-200"
                            :class="selectedValue === 'lain'
                                ? 'border-amber-400 bg-amber-50 text-amber-800'
                                : (selectedValue ? 'border-red-400 bg-red-50 text-gray-800' : 'border-gray-200 bg-gray-50 text-gray-400')">
                            <span x-text="selectedLabel" class="truncate flex-1"></span>
                            <svg class="w-5 h-5 shrink-0 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 right-0 z-50 mt-2 bg-white border border-gray-200 rounded-2xl shadow-2xl overflow-hidden"
                             style="display: none;">

                            {{-- Search --}}
                            <div class="p-3 border-b border-gray-100 bg-gray-50/80">
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                                    </svg>
                                    <input type="text"
                                        x-model="search"
                                        @click.stop
                                        placeholder="Cari nama instansi..."
                                        class="w-full pl-9 pr-4 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-red-400 transition-colors">
                                </div>
                            </div>

                            <div class="overflow-y-auto" style="max-height: 280px;">

                                {{-- Opsi Khusus: Instansi Lain --}}
                                <button type="button"
                                    @click="selectLain()"
                                    class="w-full px-4 py-3.5 flex items-center gap-3 text-left border-b-2 border-amber-100 bg-amber-50 hover:bg-amber-100 transition-colors group">
                                    <span class="shrink-0 w-8 h-8 rounded-lg bg-amber-200 text-amber-700 flex items-center justify-center group-hover:bg-amber-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-black text-amber-800">Instansi lain (tidak ada dalam daftar)</p>
                                        <p class="text-xs text-amber-600 font-medium mt-0.5">Klik untuk mengetik nama instansi Anda sendiri</p>
                                    </div>
                                </button>

                                {{-- Pemisah --}}
                                <div class="px-4 py-2 bg-gray-50 border-b border-gray-100">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Daftar Instansi Tersedia</p>
                                </div>

                                {{-- List Instansi --}}
                                <template x-for="inst in filtered" :key="inst.id">
                                    <button type="button"
                                        @click="selectInstansi(inst.id, inst.label)"
                                        class="w-full px-4 py-3 flex items-center gap-3 text-left text-sm transition-colors border-b border-gray-50 last:border-0"
                                        :class="selectedValue === inst.id ? 'bg-red-50 text-red-700 font-bold' : 'text-gray-700 hover:bg-gray-50'">
                                        <span class="w-2 h-2 rounded-full shrink-0 transition-colors"
                                              :class="selectedValue === inst.id ? 'bg-red-500' : 'bg-gray-300'"></span>
                                        <span class="flex-1 truncate" x-text="inst.label"></span>
                                        <svg x-show="selectedValue === inst.id"
                                            class="w-4 h-4 text-red-500 shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </template>

                                {{-- Kosong --}}
                                <div x-show="filtered.length === 0" class="px-4 py-10 text-center">
                                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm text-gray-400 font-medium">Instansi tidak ditemukan</p>
                                </div>
                            </div>
                        </div>

                        {{-- Input teks muncul jika pilih "Instansi Lain" --}}
                        <div x-show="mode === 'lain'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="mt-3"
                             style="display: none;">
                            <label class="block text-xs font-black text-amber-600 uppercase mb-2 tracking-wider items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Tulis Nama Instansi / Sekolah Anda
                            </label>
                            <input type="text"
                                name="instansi_lain"
                                value="{{ old('instansi_lain', $pendaftaran?->instansi_lain ?? '') }}"
                                placeholder="Contoh: SMK Muhammadiyah 3 Yogyakarta"
                                :required="mode === 'lain'"
                                class="w-full bg-amber-50 border-2 border-amber-300 rounded-xl px-5 py-4 text-sm focus:border-amber-500 outline-none transition-colors text-amber-900 placeholder-amber-300">
                            <p class="text-xs text-amber-500 mt-1.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Data ini akan ditinjau admin. Pastikan nama instansi sudah benar.
                            </p>
                        </div>
                    </div>


                    <div>
                        <label class="block text-sm font-black text-gray-700 uppercase mb-2">Kategori Peserta</label>
                        <select name="kategori"
                            class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                            required>
                            <option value="siswa"
                                {{ old('kategori', $pendaftaran->kategori ?? '') == 'siswa' ? 'selected' : '' }}>
                                Siswa (SMK/SMA)
                            </option>
                            <option value="mahasiswa"
                                {{ old('kategori', $pendaftaran->kategori ?? '') == 'mahasiswa' ? 'selected' : '' }}>
                                Mahasiswa
                            </option>
                        </select>
                    </div>

                    <div></div>

                    <div>
                        <label class="block text-sm font-black text-gray-700 uppercase mb-2">Mulai Magang</label>
                        <input type="date" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai', isset($pendaftaran->tanggal_mulai) ? $pendaftaran->tanggal_mulai->format('Y-m-d') : '') }}"
                            class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-black text-gray-700 uppercase mb-2">Selesai Magang</label>
                        <input type="date" name="tanggal_selesai"
                            value="{{ old('tanggal_selesai', isset($pendaftaran->tanggal_selesai) ? $pendaftaran->tanggal_selesai->format('Y-m-d') : '') }}"
                            class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                            required>
                    </div>
                </div>
            </div>

            @if ($tipe == 'individu')
                <div class="bg-white border-2 border-gray-100 p-8 rounded-3xl shadow-sm">
                    <div class="flex items-center gap-3 mb-8 border-b-2 border-gray-50 pb-4">
                        <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">
                            02</div>
                        <h3 class="text-lg font-black text-gray-900 uppercase">Data Pribadi & Akademik</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">NIM / NISN</label>
                            <input type="text" name="nim_nisn"
                                value="{{ old('nim_nisn', $pendaftaran->nim_nisn ?? '') }}"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                                placeholder="Masukkan nomor induk" inputmode="numeric" pattern="[0-9]*" required>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan', $pendaftaran->jurusan ?? '') }}"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                                placeholder="Contoh: Teknik Informatika" required>
                        </div>



                        <div>
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir ?? '') }}"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                                placeholder="Contoh: Yogyakarta" required>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', isset($pendaftaran->tanggal_lahir) ? $pendaftaran->tanggal_lahir->format('Y-m-d') : '') }}"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                                required>
                        </div>



                        <div>
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">Jenis Kelamin</label>
                            <div class="flex gap-6 mt-3">
                                <label class="flex items-center gap-2 font-bold text-gray-600">
                                    <input type="radio" name="jenis_kelamin" value="laki-laki"
                                        {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}
                                        class="text-red-600 focus:ring-red-500" required> Laki-laki
                                </label>
                                <label class="flex items-center gap-2 font-bold text-gray-600">
                                    <input type="radio" name="jenis_kelamin" value="perempuan"
                                        {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}
                                        class="text-red-600 focus:ring-red-500" required> Perempuan
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">Kontak / WA</label>
                            <input type="text" name="kontak" value="{{ old('kontak', $pendaftaran->kontak ?? '') }}"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                                placeholder="08..." inputmode="numeric" pattern="[0-9]*" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                                placeholder="Jl. Nama Jalan, No, RT/RW, Kec, Kab" required>{{ old('alamat', $pendaftaran->alamat ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white border-2 border-gray-100 p-8 rounded-3xl shadow-sm">
                    <div class="flex justify-between items-center mb-8 border-b-2 border-gray-50 pb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">
                                02</div>
                            <h3 class="text-lg font-black text-gray-900 uppercase">Data Anggota Kelompok</h3>
                        </div>
                        <button type="button" onclick="tambahAnggotaKel()"
                            class="bg-gray-900 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase hover:bg-red-600 transition">
                            + Tambah Anggota
                        </button>
                    </div>

                    <div class="p-6 bg-red-50 border-2 border-red-200 rounded-2xl relative mb-6">
                        <div
                            class="absolute -top-3 left-4 bg-red-600 text-white text-[10px] font-black uppercase px-4 py-1.5 rounded-full">
                            Anggota 1 (Ketua / Anda)
                        </div>

                        <p class="font-bold text-lg text-red-900 mb-6 mt-2">{{ Auth::user()->name }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">NIM / NISN</label>
                                <input type="text" name="nim_nisn"
                                    value="{{ old('nim_nisn', $pendaftaran->nim_nisn ?? '') }}"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-4 py-3 focus:border-red-500"
                                    placeholder="NIM / NISN Anda" inputmode="numeric" pattern="[0-9]*" required>
                            </div>

                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Jurusan</label>
                                <input type="text" name="jurusan"
                                    value="{{ old('jurusan', $pendaftaran->jurusan ?? '') }}"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-4 py-3 focus:border-red-500"
                                    placeholder="Jurusan Anda" required>
                            </div>



                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir ?? '') }}"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-4 py-3 focus:border-red-500"
                                    placeholder="Tempat Lahir Anda" required>
                            </div>

                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', isset($pendaftaran->tanggal_lahir) ? $pendaftaran->tanggal_lahir->format('Y-m-d') : '') }}"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-4 py-3 focus:border-red-500 text-gray-500"
                                    required>
                            </div>



                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Jenis Kelamin</label>
                                <div class="flex gap-6 mt-3">
                                    <label class="flex items-center gap-2 font-bold text-gray-600">
                                        <input type="radio" name="jenis_kelamin" value="laki-laki"
                                            {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin ?? '') == 'laki-laki' ? 'checked' : '' }}
                                            required> Laki-laki
                                    </label>
                                    <label class="flex items-center gap-2 font-bold text-gray-600">
                                        <input type="radio" name="jenis_kelamin" value="perempuan"
                                            {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin ?? '') == 'perempuan' ? 'checked' : '' }}
                                            required> Perempuan
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Kontak / WA</label>
                                <input type="text" name="kontak"
                                    value="{{ old('kontak', $pendaftaran->kontak ?? '') }}"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-4 py-3 focus:border-red-500"
                                    placeholder="Kontak / WA Anda" inputmode="numeric" pattern="[0-9]*" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-4 py-3 focus:border-red-500"
                                    placeholder="Alamat Lengkap Anda" required>{{ old('alamat', $pendaftaran->alamat ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <script>
                        window.dataAnggotaLama = @json($pendaftaran && $pendaftaran->anggota ? $pendaftaran->anggota : [])
                    </script>
                    <div id="wrapper_anggota" class="space-y-6"></div>
                </div>
            @endif

            <div class="bg-white border-2 border-gray-100 p-8 rounded-3xl shadow-sm">
                <div class="flex justify-between items-center mb-8 border-b-2 border-gray-50 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">
                            03</div>
                        <h3 class="text-lg font-black text-gray-900 uppercase">Dokumen Pendukung</h3>
                    </div>
                    <button type="button" id="add-row"
                        class="bg-gray-900 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase hover:bg-red-600 transition">
                        + Tambah Baris
                    </button>
                </div>

                <div id="document-wrapper" class="space-y-4">
                    @if (!empty($pendaftaran) && $pendaftaran->dokumen->count() > 0)
                        @foreach ($pendaftaran->dokumen as $index => $dok)
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-6 rounded-2xl border-2 border-gray-100 items-end relative">
                                <input type="hidden" name="dokumen_id[]" value="{{ $dok->id }}">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Jenis
                                        Dokumen</label>
                                    <input type="text" name="tipe_dokumen[]" value="{{ $dok->tipe_dokumen }}"
                                        readonly
                                        class="w-full bg-gray-100 text-gray-500 border-2 border-gray-200 rounded-xl px-4 py-3 cursor-not-allowed"
                                        required>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">File Saat Ini:
                                        <span class="text-red-600">{{ $dok->nama_dokumen }}</span></label>
                                    <div class="flex items-center gap-3">
                                        <input type="file" name="dokumen_{{ $dok->id }}"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-red-50 file:text-red-700">

                                        @if ($index > 0)
                                            <button type="button"
                                                class="remove-row bg-red-100 text-red-600 w-10 h-10 rounded-xl flex items-center justify-center font-bold hover:bg-red-600 hover:text-white transition">×</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-6 rounded-2xl border-2 border-gray-100 items-end">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Jenis
                                    Dokumen</label>
                                <select name="tipe_dokumen[]"
                                    class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3" required>
                                    <option value="" selected disabled>Pilih Jenis Dokumen</option>
                                    <option value="CV">CV</option>
                                    <option value="Surat Pengantar">Surat Pengantar</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Upload File
                                    Baru</label>
                                <input type="file" name="dokumen[]"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-red-50 file:text-red-700"
                                    required>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gray-900 text-white py-6 rounded-3xl font-black uppercase tracking-[0.2em] hover:bg-red-600 transition-all shadow-xl hover:shadow-red-500/20">
                Submit Pendaftaran
            </button>
        </form>
    </div>
@endsection
