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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-black text-gray-700 uppercase mb-2">Asal Instansi / Sekolah</label>
                        <select name="instansi_id"
                            class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                            required>
                            <option value="" disabled selected>-- Pilih Instansi --</option>
                            @foreach ($instansis as $inst)
                                <option value="{{ $inst->id }}"
                                    {{ old('instansi_id', $pendaftaran->instansi_id ?? '') == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->nama_instansi }} ({{ strtoupper($inst->tipe) }})
                                </option>
                            @endforeach
                        </select>
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
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">Kelas / Semester</label>
                            <input type="text" name="kelas_semester"
                                value="{{ old('kelas_semester', $pendaftaran->kelas_semester ?? '') }}"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                                placeholder="Contoh: XII / Semester 5" required>
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
                            <label class="block text-sm font-black text-gray-700 uppercase mb-2">Agama</label>
                            <input type="text" name="agama" value="{{ old('agama', $pendaftaran->agama ?? '') }}"
                                class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 focus:border-red-500"
                                placeholder="Contoh: Islam" required>
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
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Kelas /
                                    Semester</label>
                                <input type="text" name="kelas_semester"
                                    value="{{ old('kelas_semester', $pendaftaran->kelas_semester ?? '') }}"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-4 py-3 focus:border-red-500"
                                    placeholder="Kelas / Semester Anda" required>
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
                                <label class="block text-sm font-black text-gray-700 uppercase mb-2">Agama</label>
                                <input type="text" name="agama"
                                    value="{{ old('agama', $pendaftaran->agama ?? '') }}"
                                    class="w-full bg-white border-2 border-red-100 rounded-xl px-4 py-3 focus:border-red-500"
                                    placeholder="Agama" required>
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
                                {{-- BUG #10 Fix: Simpan dokumen_id agar controller tahu dokumen mana yang diupdate --}}
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
