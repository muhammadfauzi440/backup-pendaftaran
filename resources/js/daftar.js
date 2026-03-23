document.addEventListener('DOMContentLoaded', function () {
    const addRowBtn = document.getElementById('add-row');
    const wrapper = document.getElementById('document-wrapper');

    if (!addRowBtn || !wrapper) return;

    addRowBtn.addEventListener('click', function () {
        const newRow = document.createElement('div');
        newRow.className =
            'grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-6 rounded-2xl border-2 border-gray-100 items-end relative';
        newRow.innerHTML = `
            <div>
                <select name="tipe_dokumen[]" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3" required>
                    <option value="" selected disabled>Pilih Jenis Dokumen</option>
                    <option value="CV">CV</option>
                    <option value="Surat Pengantar">Surat Pengantar</option>
                </select>
            </div>
            <div class="flex items-center gap-3">
                <input type="file" name="dokumen[]"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                    required>
                <button type="button"
                    class="remove-row bg-red-100 text-red-600 w-10 h-10 rounded-xl flex items-center justify-center font-bold hover:bg-red-600 hover:text-white transition flex-shrink-0">
                    <span class="mb-1">
                        ×
                    </span>
                </button>
            </div>
        `;
        wrapper.appendChild(newRow);
    });

    wrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            const rows = wrapper.querySelectorAll('.grid');
            if (rows.length > 1) {
                e.target.closest('.grid').remove();
            } else {
                alert('Minimal satu dokumen harus diupload.');
            }
        }
    });
});

document.addEventListener('input', function(e) {
    if (e.target.matches('input[name*="nim_nisn"], input[name*="kontak"]')) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    }
});