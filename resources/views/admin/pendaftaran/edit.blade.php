@extends('admin.dashboard')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="max-w-5xl mx-auto py-10 px-6">
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
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Edit Profil</h1>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 rounded-r-xl">
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

            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">01</div>
                        <h2 class="text-lg font-black uppercase tracking-[0.2em] text-gray-900"> Informasi Pribadi</h2>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" 
                                value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('Y-m-d') : '') }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                                <option value="laki-laki" {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Agama</label>
                            <input type="text" name="agama" value="{{ old('agama', $pendaftaran->agama) }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Kontak WhatsApp</label>
                            <input type="text" name="kontak" value="{{ old('kontak', $pendaftaran->kontak) }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all resize-none">{{ old('alamat', $pendaftaran->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">02</div>
                        <h2 class="text-lg font-black uppercase tracking-[0.2em] text-gray-900"> Detail Akademik & Waktu Magang</h2>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Kategori</label>
                            <select name="kategori" class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                                <option value="siswa" {{ old('kategori', $pendaftaran->kategori) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="mahasiswa" {{ old('kategori', $pendaftaran->kategori) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">NIM / NISN</label>
                            <input type="text" name="nim_nisn" value="{{ old('nim_nisn', $pendaftaran->nim_nisn) }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Instansi</label>
                            <select name="instansi_id" class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                                @foreach ($instansis as $ins)
                                    <option value="{{ $ins->id }}" {{ old('instansi_id', $pendaftaran->instansi_id) == $ins->id ? 'selected' : '' }}>{{ $ins->nama_instansi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan', $pendaftaran->jurusan) }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Kelas / Semester</label>
                            <input type="text" name="kelas_semester" value="{{ old('kelas_semester', $pendaftaran->kelas_semester) }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pendaftaran->tanggal_mulai ? $pendaftaran->tanggal_mulai->format('Y-m-d') : '') }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pendaftaran->tanggal_selesai ? $pendaftaran->tanggal_selesai->format('Y-m-d') : '') }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Durasi (Bulan)</label>
                            <input type="number" name="durasi_bulan" value="{{ old('durasi_bulan', $pendaftaran->durasi_bulan) }}" disabled 
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-6">
                    <div class="flex items-center gap-3 px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">03</div>
                        <h2 class="text-lg font-black uppercase tracking-[0.2em] text-gray-900"> Lampiran Berkas</h2>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            @forelse ($pendaftaran->dokumen as $dok)
                                <div x-data="{ isSelected: false }" :class="isSelected ? 'bg-red-50 border-red-200 opacity-60' : 'bg-gray-200 border-transparent'"
                                     class="group flex items-center justify-between p-4 rounded-2xl border-2 transition-all duration-300">
                                    
                                    <div class="flex items-center gap-4 overflow-hidden">
                                        <div :class="isSelected ? 'bg-red-600 text-white' : 'bg-white text-red-600'" 
                                             class="p-3 rounded-xl shadow-sm transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ $dok->tipe_dokumen }}</span>
                                            <span :class="isSelected ? 'line-through text-red-900' : 'text-gray-900'" 
                                                  class="text-xs font-bold truncate max-w- md:max-w-sm transition-all">
                                                {{ $dok->nama_dokumen }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank"
                                            class="p-2 bg-white text-gray-900 rounded-lg shadow-sm hover:bg-gray-900 hover:text-white transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <label class="relative flex items-center justify-center p-2 rounded-lg cursor-pointer transition-all border border-transparent"
                                               :class="isSelected ? 'bg-red-600 text-white shadow-lg' : 'bg-red-50 text-red-600 hover:bg-red-100'">
                                            
                                            <input type="checkbox" name="hapus_dokumen[]" value="{{ $dok->id }}" 
                                                   class="hidden" 
                                                   @click="isSelected = !isSelected">
                                            
                                            <svg x-show="!isSelected" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            
                                            <span x-show="isSelected" class="text-[8px] font-black uppercase px-1">Batalkan</span>
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="md:col-span-2 text-center py-6 border-2 border-dashed border-gray-100 rounded-2xl">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Belum ada lampiran berkas</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="space-y-4 pt-6 border-t border-gray-50">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Unggah Berkas Baru</label>
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
                </div>

                <div class="flex items-center justify-end gap-4 pt-6">
                    <a href="{{ route('admin.pendaftaran.index') }}"
                        class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-all">Batalkan</a>
                    <button type="submit"
                        class="px-10 py-4 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-gray-900/20 hover:bg-red-600 transition-all transform active:scale-95">
                        Simpan Perubahan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection