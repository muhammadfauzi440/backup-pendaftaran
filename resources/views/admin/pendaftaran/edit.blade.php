@extends('admin.dashboard')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <a href="{{ route('admin.pendaftaran.index') }}"
                    class="group flex items-center text-[10px] font-black uppercase tracking-widest text-red-600 hover:text-red-700 transition-all mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
                <h1 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Edit Profil Pendaftar</h1>
            </div>
            <div>
                <span
                    class="text-[10px] font-black uppercase px-4 py-2 bg-gray-100 text-gray-600 rounded-full tracking-widest shadow-sm">
                    Tipe: <span class="text-gray-900">{{ strtoupper($pendaftaran->tipe_pendaftaran) }}</span>
                </span>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 rounded-r-xl shadow-sm">
                <h3 class="text-red-800 font-black uppercase text-xs mb-2">Terjadi Kesalahan:</h3>
                <ul class="list-disc list-inside text-red-600 text-[10px] font-bold uppercase tracking-widest space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pendaftaran.update', $pendaftaran->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <div class="bg-white rounded-[2.5rem] border-2 border-gray-50 shadow-sm overflow-hidden p-10">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                        <div
                            class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-red-200">
                            01</div>
                        <h2 class="text-lg font-black uppercase tracking-[0.15em] text-gray-900">Informasi Magang</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2 md:col-span-2"
                            x-data="{
                                mode: '{{ old('instansi_id') === null && $pendaftaran->instansi_lain ? 'lain' : 'pilih' }}',
                                init() {
                                    @if(old('instansi_id') === null && $pendaftaran->instansi_lain)
                                        this.mode = 'lain';
                                    @endif
                                }
                            }">
                            <label class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Instansi / Sekolah</label>

                            <select name="instansi_id"
                                x-on:change="mode = $event.target.value === 'lain' ? 'lain' : 'pilih'"
                                class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none transition-all">
                                <option value="" disabled {{ !$pendaftaran->instansi_id && !$pendaftaran->instansi_lain ? 'selected' : '' }}>-- Pilih Instansi --</option>
                                @foreach ($instansis as $ins)
                                    <option value="{{ $ins->id }}"
                                        {{ old('instansi_id', $pendaftaran->instansi_id) == $ins->id ? 'selected' : '' }}>
                                        {{ $ins->nama_instansi }}
                                    </option>
                                @endforeach
                                <option value="lain"
                                    {{ !$pendaftaran->instansi_id && $pendaftaran->instansi_lain ? 'selected' : '' }}>
                                    Instansi lain (tidak ada dalam daftar)
                                </option>
                            </select>

                            <div x-show="mode === 'lain'"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="mt-3">
                                <label class="block text-xs font-black text-gray-900 uppercase mb-2 tracking-widest ml-1">
                                    Nama Instansi / Sekolah 
                                </label>
                                <input type="text"
                                    name="instansi_lain"
                                    value="{{ old('instansi_lain', $pendaftaran->instansi_lain ?? '') }}"
                                    placeholder="Contoh: SMK Muhammadiyah 3 Yogyakarta"
                                    :required="mode === 'lain'"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none transition-all placeholder-gray-300">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Kategori</label>
                            <select name="kategori"
                                class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none transition-all">
                                <option value="siswa"
                                    {{ old('kategori', $pendaftaran->kategori) == 'siswa' ? 'selected' : '' }}>Siswa
                                </option>
                                <option value="mahasiswa"
                                    {{ old('kategori', $pendaftaran->kategori) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                                </option>
                            </select>
                        </div>
                        <div></div>
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Tanggal
                                Mulai</label>
                            <input type="date" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai', $pendaftaran->tanggal_mulai ? $pendaftaran->tanggal_mulai->format('Y-m-d') : '') }}"
                                class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Tanggal
                                Selesai</label>
                            <input type="date" name="tanggal_selesai"
                                value="{{ old('tanggal_selesai', $pendaftaran->tanggal_selesai ? $pendaftaran->tanggal_selesai->format('Y-m-d') : '') }}"
                                class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] border-2 border-gray-50 shadow-sm overflow-hidden p-10">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                        <div
                            class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-red-200">
                            02</div>
                        <h2 class="text-lg font-black uppercase tracking-[0.15em] text-gray-900">
                            {{ $pendaftaran->tipe_pendaftaran == 'kelompok' ? 'Data Anggota Kelompok' : 'Data Pribadi & Akademik' }}
                        </h2>
                    </div>

                    @if ($pendaftaran->tipe_pendaftaran == 'kelompok')
                        <div class="mb-8 p-8 bg-red-50 border-2 border-red-100 rounded-3xl relative">
                            <div
                                class="absolute -top-4 left-6 bg-red-600 text-white text-[10px] font-black uppercase px-4 py-2 rounded-full shadow-md tracking-widest">
                                Anggota 1 (Ketua)
                            </div>
                            <div class="mt-4 mb-6">
                                <label class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Nama
                                    Lengkap (Ketua)</label>
                                <input type="text" value="{{ $pendaftaran->user->name }}"
                                    class="w-full bg-gray-100 border-2 border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-500 cursor-not-allowed mt-1"
                                    readonly disabled title="Nama ketua diubah di pengaturan akun user">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2"><label
                                        class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">NIM /
                                        NISN</label><input type="text" name="nim_nisn"
                                        value="{{ old('nim_nisn', $pendaftaran->nim_nisn) }}"
                                        class="w-full bg-white border-2 border-red-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                </div>
                                <div class="space-y-2"><label
                                        class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Jurusan</label><input
                                        type="text" name="jurusan" value="{{ old('jurusan', $pendaftaran->jurusan) }}"
                                        class="w-full bg-white border-2 border-red-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                </div>

                                <div class="space-y-2"><label
                                        class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Jenis
                                        Kelamin</label><select name="jenis_kelamin"
                                        class="w-full bg-white border-2 border-red-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                        <option value="laki-laki"
                                            {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="perempuan"
                                            {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select></div>
                                <div class="space-y-2"><label
                                        class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Tempat
                                        Lahir</label><input type="text" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}"
                                        class="w-full bg-white border-2 border-red-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                </div>
                                <div class="space-y-2"><label
                                        class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Tanggal
                                        Lahir</label><input type="date" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('Y-m-d') : '') }}"
                                        class="w-full bg-white border-2 border-red-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                </div>

                                <div class="space-y-2"><label
                                        class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Kontak/WA</label><input
                                        type="text" name="kontak" value="{{ old('kontak', $pendaftaran->kontak) }}"
                                        class="w-full bg-white border-2 border-red-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                </div>
                                <div class="md:col-span-2 space-y-2"><label
                                        class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Alamat</label>
                                    <textarea name="alamat" rows="2"
                                        class="w-full bg-white border-2 border-red-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">{{ old('alamat', $pendaftaran->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        @foreach ($pendaftaran->anggota as $index => $anggota)
                            <div class="mb-8 p-8 bg-gray-50 border-2 border-gray-100 rounded-3xl relative">
                                <div
                                    class="absolute -top-4 left-6 bg-gray-900 text-white text-[10px] font-black uppercase px-4 py-2 rounded-full shadow-md tracking-widest">
                                    Anggota {{ $index + 2 }}
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                    <div class="md:col-span-2 space-y-2"><label
                                            class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Nama
                                            Lengkap</label><input type="text"
                                            name="anggota[{{ $anggota->id }}][nama]"
                                            value="{{ old('anggota.' . $anggota->id . '.nama', $anggota->nama) }}"
                                            class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                    </div>
                                    <div class="space-y-2"><label
                                            class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">NIM
                                            / NISN</label><input type="text"
                                            name="anggota[{{ $anggota->id }}][nim_nisn]"
                                            value="{{ old('anggota.' . $anggota->id . '.nim_nisn', $anggota->nim_nisn) }}"
                                            class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                    </div>
                                    <div class="space-y-2"><label
                                            class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Jurusan</label><input
                                            type="text" name="anggota[{{ $anggota->id }}][jurusan]"
                                            value="{{ old('anggota.' . $anggota->id . '.jurusan', $anggota->jurusan) }}"
                                            class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                    </div>

                                    <div class="space-y-2"><label
                                            class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Jenis
                                            Kelamin</label><select name="anggota[{{ $anggota->id }}][jenis_kelamin]"
                                            class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                            <option value="laki-laki"
                                                {{ old('anggota.' . $anggota->id . '.jenis_kelamin', $anggota->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="perempuan"
                                                {{ old('anggota.' . $anggota->id . '.jenis_kelamin', $anggota->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select></div>
                                    <div class="space-y-2"><label
                                            class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Tempat
                                            Lahir</label><input type="text"
                                            name="anggota[{{ $anggota->id }}][tempat_lahir]"
                                            value="{{ old('anggota.' . $anggota->id . '.tempat_lahir', $anggota->tempat_lahir) }}"
                                            class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                    </div>
                                    <div class="space-y-2"><label
                                            class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Tanggal
                                            Lahir</label><input type="date"
                                            name="anggota[{{ $anggota->id }}][tanggal_lahir]"
                                            value="{{ old('anggota.' . $anggota->id . '.tanggal_lahir', $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('Y-m-d') : '') }}"
                                            class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                    </div>

                                    <div class="space-y-2"><label
                                            class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Kontak/WA</label><input
                                            type="text" name="anggota[{{ $anggota->id }}][kontak]"
                                            value="{{ old('anggota.' . $anggota->id . '.kontak', $anggota->kontak) }}"
                                            class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                    </div>
                                    <div class="md:col-span-2 space-y-2"><label
                                            class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Alamat</label>
                                        <textarea name="anggota[{{ $anggota->id }}][alamat]" rows="2"
                                            class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">{{ old('anggota.' . $anggota->id . '.alamat', $anggota->alamat) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2"><label
                                    class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">NIM /
                                    NISN</label><input type="text" name="nim_nisn"
                                    value="{{ old('nim_nisn', $pendaftaran->nim_nisn) }}"
                                    class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                            </div>
                            <div class="space-y-2"><label
                                    class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Jurusan</label><input
                                    type="text" name="jurusan" value="{{ old('jurusan', $pendaftaran->jurusan) }}"
                                    class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                            </div>

                            <div class="space-y-2"><label
                                    class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Jenis
                                    Kelamin</label><select name="jenis_kelamin"
                                    class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                                    <option value="laki-laki"
                                        {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="perempuan"
                                        {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select></div>
                            <div class="space-y-2"><label
                                    class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Tempat
                                    Lahir</label><input type="text" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}"
                                    class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                            </div>
                            <div class="space-y-2"><label
                                    class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Tanggal
                                    Lahir</label><input type="date" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('Y-m-d') : '') }}"
                                    class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                            </div>

                            <div class="space-y-2"><label
                                    class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Kontak/WA</label><input
                                    type="text" name="kontak" value="{{ old('kontak', $pendaftaran->kontak) }}"
                                    class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">
                            </div>
                            <div class="md:col-span-2 space-y-2"><label
                                    class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Alamat</label>
                                <textarea name="alamat" rows="2"
                                    class="w-full bg-white border-2 border-gray-100 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 outline-none">{{ old('alamat', $pendaftaran->alamat) }}</textarea>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-[2.5rem] border-2 border-gray-50 shadow-sm overflow-hidden p-10">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                        <div
                            class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-red-200">
                            03</div>
                        <h2 class="text-lg font-black uppercase tracking-[0.15em] text-gray-900">Lampiran Berkas</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        @forelse ($pendaftaran->dokumen as $dok)
                            <div x-data="{ isSelected: false }"
                                :class="isSelected ? 'bg-red-50 border-red-200 opacity-60' : 'bg-gray-50 border-gray-100'"
                                class="group flex items-center justify-between p-4 rounded-2xl border-2 transition-all duration-300">
                                <div class="flex items-center gap-4 overflow-hidden">
                                    <div :class="isSelected ? 'bg-red-600 text-white' : 'bg-white text-red-600'"
                                        class="p-3 rounded-xl transition-colors shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ $dok->tipe_dokumen }}</span>
                                        <span :class="isSelected ? 'line-through text-red-900' : 'text-gray-900'"
                                            class="text-xs font-bold truncate max-w-37.5 transition-all">
                                            {{ $dok->nama_dokumen }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank"
                                        class="p-2 bg-white text-gray-900 rounded-lg shadow-sm hover:bg-gray-900 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <label
                                        class="relative flex items-center justify-center p-2 rounded-lg cursor-pointer transition-all border border-transparent"
                                        :class="isSelected ? 'bg-red-600 text-white shadow-lg' :
                                            'bg-red-50 text-red-600 hover:bg-red-100'">
                                        <input type="checkbox" name="hapus_dokumen[]" value="{{ $dok->id }}"
                                            class="hidden" @click="isSelected = !isSelected">
                                        <svg x-show="!isSelected" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span x-show="isSelected"
                                            class="text-[8px] font-black uppercase px-1">Batal</span>
                                    </label>
                                </div>
                            </div>
                        @empty
                            <div class="md:col-span-2 text-center py-6 border-2 border-dashed border-gray-100 rounded-2xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Belum ada lampiran
                                    berkas</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="space-y-4 pt-6 border-t border-gray-50">
                        <label class="text-xs font-black uppercase tracking-widest text-gray-900 ml-1 mb-2 inline-block">Unggah Berkas
                            Baru</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="file" name="dokumen_baru[]" multiple
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-bold text-gray-700 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gray-900 file:text-white hover:file:bg-red-600">
                            </div>
                            <div class="flex items-center text-[9px] text-gray-400 italic">
                                Format: PDF, JPG, PNG (Max 2MB). Pilih beberapa file sekaligus jika perlu.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6">
                    <a href="{{ route('admin.pendaftaran.index') }}"
                        class="px-8 py-4 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-red-600 transition-all">Batalkan</a>
                    <button type="submit"
                        class="px-10 py-4 bg-gray-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-gray-900/20 hover:bg-red-600 transition-all transform active:scale-95">
                        Simpan Perubahan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
