let countAnggota = 0;

window.tambahAnggotaKel = function() {
    const wrapper = document.getElementById('wrapper_anggota');
    
    if (!wrapper) return; 

    const html = `
        <div class="p-6 bg-gray-50 border-2 border-gray-200 rounded-2xl relative mb-4">
            <div class="absolute -top-3 left-4 bg-red-600 text-white text-[10px] font-black uppercase px-4 py-1.5 rounded-full">Anggota ${countAnggota + 1}</div>
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 text-red-500 font-bold hover:text-red-700">X</button>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <div class="md:col-span-2"><input type="text" name="anggota[${countAnggota}][nama]" placeholder="Nama Lengkap" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></div>
                <div><input type="text" name="anggota[${countAnggota}][nim_nisn]" placeholder="NIM / NISN" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></div>
                <div><input type="text" name="anggota[${countAnggota}][jurusan]" placeholder="Jurusan" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></div>
                <div><input type="text" name="anggota[${countAnggota}][kelas_semester]" placeholder="Kelas / Semester" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></div>
                <div><input type="text" name="anggota[${countAnggota}][tempat_lahir]" placeholder="Tempat Lahir" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></div>
                <div><input type="date" name="anggota[${countAnggota}][tanggal_lahir]" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></div>
                <div class="flex gap-4 items-center">
                    <label><input type="radio" name="anggota[${countAnggota}][jenis_kelamin]" value="laki-laki" required> Laki-laki</label>
                    <label><input type="radio" name="anggota[${countAnggota}][jenis_kelamin]" value="perempuan" required> Perempuan</label>
                </div>
                <div><input type="text" name="anggota[${countAnggota}][agama]" placeholder="Agama" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></div>
                <div><input type="text" name="anggota[${countAnggota}][kontak]" placeholder="Kontak / WA" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></div>
                <div class="md:col-span-2"><textarea name="anggota[${countAnggota}][alamat]" placeholder="Alamat Lengkap" rows="2" class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 focus:border-red-500" required></textarea></div>
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