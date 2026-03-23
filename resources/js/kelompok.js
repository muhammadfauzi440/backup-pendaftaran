let countAnggota = 0;

window.tambahAnggotaKel = function() {
    const wrapper = document.getElementById('wrapper_anggota');
    
    if (!wrapper) return; 

    const html = `
        <div class="mb-6 p-6 bg-gray-50 border-2 border-gray-200 rounded-2xl relative">
            <div class="absolute -top-3 left-4 bg-gray-900 text-white text-[10px] font-black uppercase px-4 py-1.5 rounded-full">
                Anggota ${countAnggota + 2}
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 text-red-500 font-bold hover:text-red-700 transition">
                X
            </button>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                <div class="md:col-span-2">
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="anggota[${countAnggota}][nama]" placeholder="Nama Lengkap" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">NIM / NISN</label>
                    <input type="text" name="anggota[${countAnggota}][nim_nisn]" placeholder="NIM / NISN" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500" required inputmode="numeric" pattern="[0-9]*">
                </div>
                
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Jurusan</label>
                    <input type="text" name="anggota[${countAnggota}][jurusan]" placeholder="Jurusan" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Kelas / Semester</label>
                    <input type="text" name="anggota[${countAnggota}][kelas_semester]" placeholder="Kelas / Semester" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tempat Lahir</label>
                    <input type="text" name="anggota[${countAnggota}][tempat_lahir]" placeholder="Tempat Lahir" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Tanggal Lahir</label>
                    <input type="date" name="anggota[${countAnggota}][tanggal_lahir]" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500 text-gray-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Jenis Kelamin</label>
                    <div class="flex gap-6 mt-3">
                        <label class="flex items-center gap-2 font-bold text-gray-600">
                            <input type="radio" name="anggota[${countAnggota}][jenis_kelamin]" value="laki-laki" class="text-red-600 focus:ring-red-500" required> Laki-laki
                        </label>
                        <label class="flex items-center gap-2 font-bold text-gray-600">
                            <input type="radio" name="anggota[${countAnggota}][jenis_kelamin]" value="perempuan" class="text-red-600 focus:ring-red-500" required> Perempuan
                        </label>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Agama</label>
                    <input type="text" name="anggota[${countAnggota}][agama]" placeholder="Agama" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Kontak / WA</label>
                    <input type="text" name="anggota[${countAnggota}][kontak]" placeholder="Kontak / WA" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500" required inputmode="numeric" pattern="[0-9]*">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-black text-gray-700 uppercase mb-2">Alamat Lengkap</label>
                    <textarea name="anggota[${countAnggota}][alamat]" placeholder="Alamat Lengkap" rows="2" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-red-500" required></textarea>
                </div>
            </div>
        </div>
    `;
    wrapper.insertAdjacentHTML('beforeend', html);
    countAnggota++;
}

document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('wrapper_anggota');
    if (wrapper && countAnggota === 0) {
        window.tambahAnggotaKel();
    }
});