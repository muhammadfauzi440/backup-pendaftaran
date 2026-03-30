<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f8fafc; padding: 20px; color: #334155; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        .header { text-align: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; }
        .title { color: #dc2626; margin: 0; font-size: 24px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; }
        .code-box { background-color: #fef2f2; border: 2px dashed #fca5a5; padding: 20px; text-align: center; border-radius: 12px; margin: 25px 0; }
        .code-text { font-size: 32px; font-weight: 900; color: #991b1b; margin: 0; letter-spacing: 4px; }
        .footer { margin-top: 30px; font-size: 12px; color: #94a3b8; text-align: center; border-top: 1px solid #f1f5f9; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Pendaftaran Berhasil!</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $pendaftaran->user->name }}</strong>,</p>
            <p>Terima kasih telah mengajukan pendaftaran magang di <strong>PT Global Intermedia Nusantara</strong>. Berkas Anda telah masuk ke dalam sistem kami dan berstatus <strong>PENDING</strong>.</p>
            <p>Berikut adalah Kode Pendaftaran Anda. Gunakan kode ini untuk mengecek status seleksi Anda melalui portal publik (tanpa perlu login):</p>
            
            <div class="code-box">
                <span style="font-size: 10px; color: #ef4444; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">Kode Anda</span>
                <h2 class="code-text">{{ $pendaftaran->kode_pendaftaran }}</h2>
            </div>

            <p>Tim admin kami akan segera melakukan verifikasi data dan dokumen. Kami akan mengirimkan email pemberitahuan selanjutnya jika status Anda telah berubah (Diterima/Ditolak).</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PT Global Intermedia Nusantara. Semua Hak Dilindungi.</p>
            <p>Email ini dibuat otomatis oleh sistem, mohon untuk tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>