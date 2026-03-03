@extends('admin.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <a href="{{ route('admin.pendaftaran.index') }}"
                class="underline text-xs font-black text-gray-800 hover:text-gray-900 uppercase tracking-widest transition">&larr;
                Kembali ke Daftar</a>
            <div class="flex gap-4">
                <span class="text-[10px] font-black uppercase px-4 py-1.5 bg-gray-100 rounded-full tracking-widest">Dibuat:
                    {{ $pendaftaran->created_at->format('d/m/Y') }}</span>
                <span
                    class="text-[10px] font-black uppercase px-4 py-1.5 {{ $pendaftaran->status == 'pending' ? 'bg-amber-100 text-amber-600' : ($pendaftaran->status == 'diterima' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600') }} rounded-full tracking-widest">Status:
                    {{ $pendaftaran->status }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white p-10 rounded-[2.5rem] border-2 border-gray-50 shadow-sm">
                    <div class="flex items-center gap-3 py-6 border-b border-gray-50 bg-gray-50/50">
                        <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">
                            01
                        </div>
                        <h2 class="text-lg font-black uppercase tracking-[0.2em] text-gray-900"> Data Pribadi</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 text-sm">
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Nama Lengkap</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Email Aktif</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Tempat, Tanggal
                                Lahir</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->tempat_lahir }},
                                {{ $pendaftaran->tanggal_lahir->format('d F Y') }}</p>
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
                        <div class="col-span-2">
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Alamat Tinggal</p>
                            <p class="font-black text-gray-900 leading-relaxed">{{ $pendaftaran->alamat }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border-2 border-gray-50 shadow-sm">
                    <div class="flex items-center gap-3 py-6 border-b border-gray-50 bg-gray-50/50">
                        <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">
                            02
                        </div>
                        <h2 class="text-lg font-black uppercase tracking-[0.2em] text-gray-900"> Informasi Akademik</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 text-sm">
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
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Kelas / Semester
                            </p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->kelas_semester }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Jurusan</p>
                            <p class="font-black text-gray-900">{{ $pendaftaran->jurusan }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mb-1">Durasi Magang</p>
                            <p class="font-black text-red-600 italic">{{ $pendaftaran->durasi_bulan }} Bulan</p>
                        </div>
                        <div class="col-span-2 bg-gray-50 p-6 rounded-2xl border border-gray-100 flex justify-between">
                            <div>
                                <p class="text-gray-400 font-bold uppercase text-[10px] mb-1">Tanggal Mulai</p>
                                <p class="font-black text-gray-900">{{ $pendaftaran->tanggal_mulai->format('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-400 font-bold uppercase text-[10px] mb-1">Tanggal Selesai</p>
                                <p class="font-black text-gray-900">{{ $pendaftaran->tanggal_selesai->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border-2 border-gray-50 shadow-sm">
                    <div class="flex items-center gap-3 py-6 border-b border-gray-50 bg-gray-50/50">
                        <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold">
                            03
                        </div>
                        <h2 class="text-lg font-black uppercase tracking-[0.2em] text-gray-900"> Lampiran Berkas</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($pendaftaran->dokumen as $dok)
                            <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank"
                                class="flex items-center justify-between p-5 bg-gray-50 rounded-2xl hover:bg-gray-100 transition border-2 border-transparent hover:border-gray-200 group">
                                <div class="flex flex-col">
                                    <span
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">{{ $dok->tipe_dokumen }}</span>
                                    <span
                                        class="text-xs font-bold text-gray-900 truncate w-40">{{ $dok->nama_dokumen }}</span>
                                </div>
                                <span
                                    class="text-[9px] font-black text-white bg-gray-900 px-3 py-1.5 rounded-lg group-hover:bg-red-600 transition shadow-sm">OPEN
                                    FILE</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-900 p-8 rounded-[2.5rem] shadow-2xl sticky top-8">
                    <h2
                        class="text-white text-lg font-black uppercase mb-6 italic tracking-tighter border-b border-white/10 pb-4">
                        Verifikasi Admin</h2>

                    <form action="{{ route('admin.pendaftaran.updateStatus', $pendaftaran->id) }}" method="POST">
                        @csrf
                        <div class="mb-8">
                            <label class="block text-[10px] font-black text-gray-500 uppercase mb-4 tracking-widest">Alasan
                                dan Keputusan <span class="text-red-500">*</span></label>
                            <textarea name="catatan_admin" rows="6" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl p-5 text-white text-sm focus:ring-red-500 focus:border-red-500 placeholder:text-gray-600"
                                placeholder="Berikan catatan kepada pendaftar">{{ $pendaftaran->catatan_admin }}</textarea>
                        </div>

                        <div class="space-y-4">
                            <button type="submit" name="status" value="diterima"
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] transition-all transform hover:-translate-y-1 shadow-lg shadow-emerald-900/20">Terima
                                Pendaftar</button>
                            <button type="submit" name="status" value="ditolak"
                                class="w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] transition-all transform hover:-translate-y-1 shadow-lg shadow-red-900/20">Tolak
                                Pendaftar</button>
                        </div>
                    </form>

                    <div class="mt-8 pt-6 border-t border-white/10">
                        <p class="text-[9px] text-gray-500 font-bold uppercase leading-relaxed tracking-widest">Peringatan:
                            Keputusan ini akan langsung terlihat oleh pendaftar pada dashboard mereka.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
