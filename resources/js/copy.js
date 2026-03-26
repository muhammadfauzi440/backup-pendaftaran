document.addEventListener('DOMContentLoaded', function() {
    const btnCopy = document.getElementById('btn-copy-kode');
    const txtKode = document.getElementById('kode-pendaftaran');

    if (btnCopy && txtKode) {
        btnCopy.addEventListener('click', function() {
            const kode = txtKode.innerText.trim();

            const showSuccessAlert = () => {
                Swal.fire({
                    icon: 'success',
                    title: 'TERSALIN!',
                    text: 'Kode pendaftaran berhasil disalin.',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                });
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(kode).then(() => {
                    showSuccessAlert();
                }).catch((err) => {
                    console.error('Gagal menyalin kode dengan clipboard API: ', err);
                    fallbackCopyTextToClipboard(kode, showSuccessAlert);
                });
            } else {
                fallbackCopyTextToClipboard(kode, showSuccessAlert);
            }
        });
    }


    function fallbackCopyTextToClipboard(kode, successCallback) {
        var textArea = document.createElement('textarea');
        textArea.value = kode;

        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        textArea.style.opacity = "0";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            if(successful) {
                successCallback();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Browser anda tidak mendukung fitur salin otomatis.'
                });
            }
        } catch(err) {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: 'Terjadi kesalahan saat menyalin kode.'
            });
        }

        document.body.removeChild(textArea);
    }
});