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
    <div class="flex items-center justify-center gap-2 text-sm text-slate-500 py-4">
        <svg class="animate-spin h-4 w-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Mengecek status pendaftaran...</span>
    </div>`;
    container.classList.remove("hidden");

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/cek-status`, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({ kode: kode })
    })
        .then((response) => {
            if (!response.ok)
                throw new Error("Gagal mengambil data status pendaftaran");
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                const badgeStyle = {
                    pending:
                        "bg-amber-100 text-amber-800 border-amber-200",
                    diterima:
                        "bg-emerald-100 text-emerald-800 border-emerald-200",
                    ditolak: "bg-red-100 text-red-800 border-red-200",
                };

                const currentBadge =
                    badgeStyle[data.status] || "bg-slate-100 text-slate-800 border-slate-200";

                content.innerHTML = `
                <div class="space-y-4 animate-in fade-in duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col space-y-1">
                            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Pendaftar</span>
                            <span class="font-semibold text-slate-900">${data.nama}</span>
                        </div>
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold capitalize transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 ${currentBadge}">
                            ${data.status}
                        </span>
                    </div>

                    ${
                        data.catatan
                            ? `
                        <div class="rounded-md border border-slate-200 bg-slate-50 p-4">
                            <h4 class="text-sm font-semibold text-slate-900 mb-1">Catatan HRD</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">${data.catatan}</p>
                        </div>
                    `
                            : `
                        <div class="rounded-md border border-slate-200 bg-slate-50 p-4">
                            <p class="text-sm text-slate-500 italic">Menunggu Verifikasi Admin</p>
                        </div>
                    `
                    }
                </div>
            `;
            } else {
                content.innerHTML = `
                <div class="flex flex-col items-center justify-center space-y-2 py-4 text-center">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-medium text-slate-900">Data Tidak Ditemukan</p>
                    <p class="text-xs text-slate-500">Pastikan kode pendaftaran yang Anda masukkan benar.</p>
                </div>
                `;
            }
        })

        .catch(error => {
        console.error('Error:', error);
        content.innerHTML = `
        <div class="flex flex-col items-center justify-center space-y-2 py-4 text-center">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-sm font-medium text-red-600">Terjadi Kesalahan</p>
            <p class="text-xs text-slate-500">Gagal memuat data. Silakan coba lagi nanti.</p>
        </div>`;
    });
};