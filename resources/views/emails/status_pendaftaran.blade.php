<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pemberitahuan Status Magang</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9fafb; color: #111827; padding: 20px; }
        .container { max-w-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 12px; border-top: 6px solid #dc2626; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { margin-bottom: 20px; text-align: center; }
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 999px; font-weight: bold; font-size: 14px; text-transform: uppercase; }
        .status-diterima { background-color: #d1fae5; color: #047857; }
        .status-ditolak { background-color: #fee2e2; color: #b91c1c; }
        .content { line-height: 1.6; color: #374151; }
        .note-box { background-color: #f3f4f6; padding: 15px; border-left: 4px solid #4b5563; margin-top: 20px; border-radius: 0 8px 8px 0; }
        .footer { margin-top: 30px; font-size: 12px; color: #9ca3af; text-align: center; border-top: 1px solid #f3f4f6; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pemberitahuan Seleksi Magang</h2>
            <p>PT Global Intermedia Nusantara</p>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $pendaftaran->user->name }}</strong>,</p>
            <p>Terima kasih telah mendaftar program magang di perusahaan kami. Berikut adalah pembaruan terbaru mengenai status pendaftaran Anda:</p>
            
            <p style="text-align: center; margin: 25px 0;">
                Status saat ini: 
                <span class="status-badge {{ $pendaftaran->status == 'diterima' ? 'status-diterima' : 'status-ditolak' }}">
                    {{ $pendaftaran->status }}
                </span>
            </p>

            <div class="note-box">
                <strong>Catatan dari HRD:</strong><br>
                {{ $pendaftaran->catatan_admin }}
            </div>

            <p style="margin-top: 25px;">
                @if($pendaftaran->status == 'diterima')
                    Selamat! Silakan periksa dashboard Anda atau tunggu instruksi selanjutnya dari tim kami untuk persiapan magang.
                @else
                    Tetap semangat! Jangan berkecil hati dan terus kembangkan kemampuan Anda. Kami menghargai ketertarikan Anda pada perusahaan kami.
                @endif
            </p>
            
            <p>Salam hangat,<br>Tim HRD PT Global Intermedia Nusantara</p>
        </div>

        <div class="footer">
            <p>Email ini dihasilkan secara otomatis oleh sistem. Mohon untuk tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>