document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.rowCheckbox');
    const bulkDeleteContainer = document.getElementById('bulkDeleteContainer');
    const selectedCountSpan = document.getElementById('selectedCount');

    function updateBulkDeleteButton() {
        const checkedCount = document.querySelectorAll('.rowCheckbox:checked').length;
        if (checkedCount > 0) {
            bulkDeleteContainer.classList.remove('hidden');
            selectedCountSpan.innerText = checkedCount;
        } else {
            bulkDeleteContainer.classList.add('hidden');
        }
    }

    if(selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkDeleteButton();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if(!this.checked) selectAll.checked = false;
            if(document.querySelectorAll('.rowCheckbox:checked').length === checkboxes.length) selectAll.checked = true;
            updateBulkDeleteButton();
        });
    });
});

window.confirmBulkDelete = function() {
    Swal.fire({
        title: 'Hapus Massal?',
        text: "Data dan berkas pendaftar yang dipilih akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#111827',
        confirmButtonText: 'Ya, Hapus Permanen!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl uppercase font-black tracking-widest text-[10px] px-6 py-3', cancelButton: 'rounded-xl uppercase font-black tracking-widest text-[10px] px-6 py-3' }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('bulkDeleteForm').submit();
        }
    });
};

window.confirmSingleDelete = function(id, name) {
    Swal.fire({
        title: 'Hapus Data?',
        text: `Apakah Anda yakin ingin menghapus permanen data milik ${name}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#111827',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl uppercase font-black tracking-widest text-[10px] px-6 py-3', cancelButton: 'rounded-xl uppercase font-black tracking-widest text-[10px] px-6 py-3' }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('singleDeleteForm');
            form.action = `/admin/kelola-pendaftaran/${id}`;
            form.submit();
        }
    });
};