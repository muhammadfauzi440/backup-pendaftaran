@extends('admin.dashboard')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-6">
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <a href="{{ route('admin.instansi.index') }}"
                    class="group flex items-center text-[10px] font-black uppercase tracking-widest text-gray-800 hover:text-blue-600 transition-all mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Instansi
                </a>
                <h1 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Edit Instansi</h1>
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

        <form action="{{ route('admin.instansi.update', $instansi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nama Instansi
                                / Perusahaan</label>
                            <input type="text" name="nama_instansi"
                                value="{{ old('nama_instansi', $instansi->nama_instansi) }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/5 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Kontak / No.
                                Telepon</label>
                            <input type="text" name="kontak_instansi" value="{{ old('kontak_instansi', $instansi->kontak_instansi) }}"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/5 outline-none transition-all">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Alamat Kantor
                                Pusat</label>
                            <textarea name="alamat_instansi" rows="4"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/5 outline-none transition-all resize-none">{{ old('alamat_instansi', $instansi->alamat_instansi) }}</textarea>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label
                                class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Kategori</label>
                            <select name="tipe"
                                class="w-full bg-white border border-gray-200 rounded-xl px-5 py-3.5 text-sm font-bold text-gray-700 focus:border-red-600 focus:ring-4 focus:ring-red-600/5 outline-none transition-all">
                                <option value="sekolah"
                                    {{ old('tipe', $instansi->tipe) == 'sekolah' ? 'selected' : '' }}>Sekolah
                                </option>
                                <option value="universitas"
                                    {{ old('tipe', $instansi->tipe) == 'universitas' ? 'selected' : '' }}>Universitas
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6">
                    <a href="{{ route('admin.instansi.index') }}"
                        class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-all">
                        Batalkan
                    </a>
                    <button type="submit"
                        class="px-10 py-4 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-gray-900/20 hover:bg-blue-600 transition-all transform active:scale-95">
                        Simpan Perubahan Instansi
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
