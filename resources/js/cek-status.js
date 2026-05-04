window.cekStatus = function () {
    const kodeInput = document.getElementById("kode_input");
    const container = document.getElementById("result_container");
    const content = document.getElementById("result_content");

    if (!kodeInput.value.trim()) {
        alert("Silahkan Masukkan Kode Pendaftaran");
        kodeInput.focus();
        return;
    }

    const kode = kodeInput.value.toUpperCase();

    content.innerHTML = `
    <div class="flex items-center gap-3 py-2">
        <div class="w-4 h-4 border-2 border-red-600 border-t-transparent rounded-full animate-spin"></div>
        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Mengecek status pendaftaran...</span>
    </div>`;
    container.classList.remove("hidden");

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/cek-status/${kode}`, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({ kode })
    })
        .then((response) => {
            if (!response.ok)
                throw new Error("Gagal mengambil data status pendaftaran");
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                const statusStyle = {
                    pending:
                        "text-amber-400 bg-amber-400/10 border-amber-400/20",
                    diterima:
                        "text-emerald-400 bg-emerald-400/10 border-emerald-400/20",
                    ditolak: "text-red-400 bg-red-400/10 border-red-400/20",
                };

                const currentStyle =
                    statusStyle[data.status] || "text-gray-400 bg-gray-400/10";

                content.innerHTML = `
                <div class="space-y-5 animate-in fade-in zoom-in duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Nama Pendaftar</p>
                            <p class="text-black text-md font-bold text-base">${data.nama}</p>
                        </div>
                        <div class="px-4 py-1.5 rounded-lg border ${currentStyle} text-[10px] font-black uppercase tracking-widest">
                            ${data.status}
                        </div>              
                    </div>

                    ${
                        data.catatan
                            ? `
                        <div class="p-4 rounded-2xl bg-white/5 border border-white/5">
                            <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mb-2">Pesan Admin:</p>
                            <p class="text-xs text-gray-300 italic leading-relaxed font-medium">${data.catatan}</p>
                        </div>
                    `
                            : `
                        <p class="text-[9px] text-gray-600 font-bold italic uppercase tracking-tighter">Menunggu Verifikasi</p>
                    `
                    }
                </div>
            `;
            } else {
                content.innerHTML = `
            <div class="flex items-center gap-3 text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <p class="text-[10px] font-black uppercase tracking-widest">Data Tidak Ditemukan!</p>
                </div>
            `;
            }
        })

        .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<p class="text-[10px] font-black text-red-600 uppercase">Gagal memuat data. Coba lagi nanti.</p>';
    });
};