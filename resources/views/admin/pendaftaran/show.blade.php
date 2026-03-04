@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <a href="{{ route('admin.pendaftaran.index') }}"
                class=" text-xs font-black text-red-600 hover:text-red-800 uppercase tracking-widest transition">
                &larr; Kembali ke Daftar
            </a>
            <div class="flex gap-4">
                <span class="text-[10px] font-black uppercase px-4 py-2 bg-gray-100 text-gray-600 rounded-full tracking-widest shadow-sm">
                    Dibuat: {{ $pendaftaran->created_at->format('d/m/Y') }}
                </span>
                <span class="text-[10px] font-black uppercase px-4 py-2 {{ $pendaftaran->status == 'pending' ? 'bg-amber-100 text-amber-600' : ($pendaftaran->status == 'diterima' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600') }} rounded-full tracking-widest shadow-sm">
                    Status: {{ $pendaftaran->status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white p-10 rounded-[2.5rem] border-2 border-gray-50 shadow-sm">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                        <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-red-200">
                            01
                        </div>
                        <h2 class="text-xl font-black uppercase tracking-[0.15em] text-gray-900">Data Pribadi</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 text-sm">
                        <div class="group">
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1 group-hover:text-red-500 transition">Nama Lengkap</p>
                            <p class="font-black text-gray-900 text-base">{{ $pendaftaran->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Email Aktif</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Tempat, Tanggal Lahir</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Jenis Kelamin</p>
                            <p class="font-black text-gray-900 uppercase">{{ $pendaftaran->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Agama</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->agama }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Kontak/WA</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->kontak }}</p>
                        </div>
                        <div class="col-span-2 p-5 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Alamat Tinggal</p>
                            <p class="font-black text-gray-900 leading-relaxed">{{ $pendaftaran->alamat }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border-2 border-gray-50 shadow-sm">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                        <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-red-200">
                            02
                        </div>
                        <h2 class="text-xl font-black uppercase tracking-[0.15em] text-gray-900">Informasi Akademik</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 text-sm">
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Kategori</p>
                            <p class="font-black text-gray-900 uppercase">{{ $pendaftaran->kategori }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">NIM / NISN</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->nim_nisn }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Instansi</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->instansi->nama_instansi }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Kelas / Semester</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->kelas_semester }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Jurusan</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->jurusan }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Durasi Magang</p>
                            <p class="font-black text-red-600 italic text-base">{{ $pendaftaran->durasi_bulan }} Bulan</p>
                        </div>
                        <div class="col-span-2 bg-gray-900 p-8 rounded-2xl border border-gray-800 flex justify-between items-center shadow-xl">
                            <div>
                                <p class="text-gray-500 font-bold uppercase text-[10px] mb-1 tracking-widest">Tanggal Mulai</p>
                                <p class="font-black text-white text-lg">{{ $pendaftaran->tanggal_mulai->format('d M Y') }}</p>
                            </div>
                            <div class="h-8 w-1 bg-white/10 hidden md:block"></div>
                            <div class="text-right">
                                <p class="text-gray-500 font-bold uppercase text-[10px] mb-1 tracking-widest">Tanggal Selesai</p>
                                <p class="font-black text-white text-lg">{{ $pendaftaran->tanggal_selesai->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border-2 border-gray-50 shadow-sm">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                        <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-red-200">
                            03
                        </div>
                        <h2 class="text-xl font-black uppercase tracking-[0.15em] text-gray-900">Lampiran Berkas</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach ($pendaftaran->dokumen as $dok)
                            <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank"
                                class="flex items-center justify-between p-6 bg-gray-50 rounded-2xl hover:bg-white transition-all border-2 border-transparent hover:border-red-600 hover:shadow-xl hover:shadow-red-500/10 group">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-red-600 uppercase mb-1 tracking-widest">{{ $dok->tipe_dokumen }}</span>
                                    <span class="text-sm font-bold text-gray-900 truncate w-40">{{ $dok->nama_dokumen }}</span>
                                </div>
                                <div class="bg-gray-900 text-white text-[9px] font-black px-4 py-2 rounded-xl group-hover:bg-red-600 transition-colors tracking-tighter shadow-sm">
                                    OPEN FILE
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-900 p-8 rounded-[2.5rem] shadow-2xl sticky top-8 border border-white/5">
                    <h2 class="text-white text-xl font-black uppercase mb-8 italic tracking-tighter border-b border-white/10 pb-4">
                        Verifikasi Admin
                    </h2>

                    <form action="{{ route('admin.pendaftaran.updateStatus', $pendaftaran->id) }}" method="POST">
                        @csrf
                        <div class="mb-8">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-4 tracking-widest">
                                Alasan & Keputusan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="catatan_admin" rows="6" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl p-5 text-white text-sm focus:ring-2 focus:ring-red-600 focus:border-transparent placeholder:text-gray-600 transition-all outline-none"
                                placeholder="Tuliskan catatan atau alasan verifikasi di sini...">{{ $pendaftaran->catatan_admin }}</textarea>
                        </div>

                        <div class="space-y-4">
                            <button type="submit" name="status" value="diterima"
                                class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] transition-all transform hover:-translate-y-1 shadow-lg shadow-emerald-900/40 active:scale-95">
                                Terima Pendaftar
                            </button>
                            <button type="submit" name="status" value="ditolak"
                                class="w-full bg-red-600 hover:bg-red-500 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] transition-all transform hover:-translate-y-1 shadow-lg shadow-red-900/40 active:scale-95">
                                Tolak Pendaftar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection