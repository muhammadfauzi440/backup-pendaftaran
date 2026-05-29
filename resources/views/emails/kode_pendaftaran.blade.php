<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; background-color: #f1f5f9; padding: 30px 16px; color: #334155; }
        .wrapper { max-width: 620px; margin: auto; }

        .container { background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }

        /* Header */
        .header { background-color: #dc2626; padding: 32px 40px; text-align: center; }
        .header-logo { font-size: 11px; color: rgba(255,255,255,0.7); font-weight: bold; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 8px; }
        .header-title { color: #ffffff; font-size: 22px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; }

        /* Body */
        .body { padding: 36px 40px; }
        .greeting { font-size: 15px; color: #334155; margin-bottom: 14px; line-height: 1.6; }

        /* Kode Box */
        .code-box { background: linear-gradient(135deg, #fef2f2, #fff5f5); border: 2px dashed #fca5a5; padding: 24px; text-align: center; border-radius: 14px; margin: 28px 0; }
        .code-label { font-size: 10px; color: #ef4444; font-weight: bold; text-transform: uppercase; letter-spacing: 3px; display: block; margin-bottom: 10px; }
        .code-text { font-size: 34px; font-weight: 900; color: #991b1b; letter-spacing: 6px; }

        /* Detail Card */
        .detail-card { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin: 24px 0; }
        .detail-title { font-size: 10px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px; }
        .detail-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 10px 0; border-bottom: 1px solid #e2e8f0; gap: 12px; }
        .detail-row:last-child { border-bottom: none; padding-bottom: 0; }
        .detail-label { font-size: 12px; color: #94a3b8; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; min-width: 140px; }
        .detail-value { font-size: 13px; color: #1e293b; font-weight: 700; text-align: right; }

        /* Badge */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-kelompok { background-color: #ede9fe; color: #5b21b6; }
        .badge-individu { background-color: #e0f2fe; color: #075985; }

        /* Anggota */
        .anggota-box { background-color: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 10px; padding: 14px 18px; margin-top: 10px; }
        .anggota-title { font-size: 10px; font-weight: 900; color: #7c3aed; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 10px; }
        .anggota-item { font-size: 12px; color: #3730a3; font-weight: 600; padding: 4px 0; border-bottom: 1px solid #ede9fe; }
        .anggota-item:last-child { border-bottom: none; }

        /* Info */
        .info-box { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 0 10px 10px 0; padding: 14px 18px; margin: 20px 0; font-size: 13px; color: #166534; line-height: 1.6; }

        /* Footer */
        .footer { background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 40px; text-align: center; }
        .footer p { font-size: 11px; color: #94a3b8; line-height: 1.8; }
        .footer .company { font-weight: 900; color: #64748b; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">

            {{-- Header --}}
            <div class="header">
                <div class="header-logo">PT Global Intermedia Nusantara</div>
                <div class="header-title">✅ Pendaftaran Berhasil!</div>
            </div>

            {{-- Body --}}
            <div class="body">
                <p class="greeting">
                    Halo <strong>{{ $pendaftaran->user->name }}</strong>,<br>
                    Terima kasih telah mengajukan pendaftaran magang di <strong>PT Global Intermedia Nusantara</strong>.
                    Berkas Anda telah masuk ke sistem dan berstatus <span class="badge badge-pending">⏳ Pending</span>.
                </p>

                {{-- Kode Pendaftaran --}}
                <div class="code-box">
                    <span class="code-label">Kode Pendaftaran Anda</span>
                    <div class="code-text">{{ $pendaftaran->kode_pendaftaran }}</div>
                </div>

                {{-- Detail Pendaftar --}}
                <div class="detail-card">
                    <div class="detail-title">📋 Ringkasan Data Pendaftaran</div>

                    <div class="detail-row">
                        <span class="detail-label">Nama Pendaftar</span>
                        <span class="detail-value">{{ $pendaftaran->user->name }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">NISN / NIM</span>
                        <span class="detail-value">{{ $pendaftaran->nim_nisn }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Tipe Pendaftaran</span>
                        <span class="detail-value">
                            @if ($pendaftaran->tipe_pendaftaran === 'kelompok')
                                <span class="badge badge-kelompok">👥 Kelompok</span>
                            @else
                                <span class="badge badge-individu">👤 Individu</span>
                            @endif
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Asal Instansi</span>
                        <span class="detail-value">{{ $pendaftaran->nama_instansi_display }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Periode Magang</span>
                        <span class="detail-value">
                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->format('d M Y') }}
                            &ndash;
                            {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)->format('d M Y') }}
                            <br>
                            <span style="font-size:11px; color:#94a3b8; font-weight:600;">
                                ({{ $pendaftaran->durasi_bulan }} Bulan)
                            </span>
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Nomor HP</span>
                        <span class="detail-value">{{ $pendaftaran->kontak }}</span>
                    </div>
                </div>

                {{-- Daftar Anggota Kelompok --}}
                @if ($pendaftaran->tipe_pendaftaran === 'kelompok' && $pendaftaran->anggota && $pendaftaran->anggota->count() > 0)
                    <div class="anggota-box">
                        <div class="anggota-title">👥 Anggota Kelompok</div>
                        @foreach ($pendaftaran->anggota as $i => $anggota)
                            <div class="anggota-item">
                                {{ $i + 1 }}. {{ $anggota->nama }}
                                <span style="color:#a78bfa; font-weight:500;"> — {{ $anggota->nim_nisn }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Info --}}
                <div class="info-box">
                    💡 Gunakan kode di atas untuk <strong>mengecek status seleksi</strong> Anda kapan saja melalui halaman publik tanpa perlu login.<br>
                    Tim admin akan segera melakukan verifikasi dan mengirimkan pemberitahuan selanjutnya via email.
                </div>
            </div>

            {{-- Footer --}}
            <div class="footer">
                <p class="company">PT Global Intermedia Nusantara</p>
                <p>&copy; {{ date('Y') }} Semua Hak Dilindungi.</p>
                <p style="margin-top: 6px;">Email ini dibuat secara otomatis oleh sistem, mohon untuk tidak membalas email ini.</p>
            </div>

        </div>
    </div>
</body>
</html>