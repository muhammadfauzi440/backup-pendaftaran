<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Status Magang</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; background-color: #f1f5f9; padding: 30px 16px; color: #334155; }
        .wrapper { max-width: 620px; margin: auto; }
        .container { background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }

        /* Header */
        .header-diterima { background-color: #059669; padding: 32px 40px; text-align: center; }
        .header-ditolak  { background-color: #dc2626; padding: 32px 40px; text-align: center; }
        .header-logo  { font-size: 11px; color: rgba(255,255,255,0.7); font-weight: bold; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 8px; }
        .header-title { color: #ffffff; font-size: 22px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; }

        /* Body */
        .body { padding: 36px 40px; }
        .greeting { font-size: 15px; color: #334155; margin-bottom: 14px; line-height: 1.6; }

        /* Status Badge */
        .status-wrap { text-align: center; margin: 24px 0; }
        .status-badge { display: inline-block; padding: 10px 28px; border-radius: 999px; font-size: 14px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; }
        .status-diterima { background-color: #d1fae5; color: #065f46; }
        .status-ditolak  { background-color: #fee2e2; color: #991b1b; }

        /* Catatan HRD */
        .note-box-diterima { background-color: #ecfdf5; border-left: 4px solid #059669; border-radius: 0 12px 12px 0; padding: 16px 18px; margin: 20px 0; font-size: 13px; color: #065f46; line-height: 1.7; }
        .note-box-ditolak  { background-color: #fef2f2; border-left: 4px solid #dc2626; border-radius: 0 12px 12px 0; padding: 16px 18px; margin: 20px 0; font-size: 13px; color: #991b1b; line-height: 1.7; }
        .note-label { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px; display: block; opacity: 0.7; }

        /* Detail Card */
        .detail-card { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin: 24px 0; }
        .detail-title { font-size: 10px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px; }
        .detail-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 10px 0; border-bottom: 1px solid #e2e8f0; gap: 12px; }
        .detail-row:last-child { border-bottom: none; padding-bottom: 0; }
        .detail-label { font-size: 12px; color: #94a3b8; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; min-width: 140px; }
        .detail-value { font-size: 13px; color: #1e293b; font-weight: 700; text-align: right; }

        /* Badge tipe */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; }
        .badge-kelompok { background-color: #ede9fe; color: #5b21b6; }
        .badge-individu { background-color: #e0f2fe; color: #075985; }

        /* Anggota */
        .anggota-box { background-color: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 10px; padding: 14px 18px; margin-top: 10px; }
        .anggota-title { font-size: 10px; font-weight: 900; color: #7c3aed; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 10px; }
        .anggota-item { font-size: 12px; color: #3730a3; font-weight: 600; padding: 4px 0; border-bottom: 1px solid #ede9fe; }
        .anggota-item:last-child { border-bottom: none; }

        /* Pesan lanjutan */
        .info-diterima { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 0 10px 10px 0; padding: 14px 18px; margin: 20px 0; font-size: 13px; color: #166534; line-height: 1.7; }
        .info-ditolak  { background-color: #fff7ed; border-left: 4px solid #f97316; border-radius: 0 10px 10px 0; padding: 14px 18px; margin: 20px 0; font-size: 13px; color: #9a3412; line-height: 1.7; }

        /* Footer */
        .footer { background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 40px; text-align: center; }
        .footer p { font-size: 11px; color: #94a3b8; line-height: 1.8; }
        .footer .company { font-weight: 900; color: #64748b; }

        .salutation { font-size: 13px; color: #334155; margin-top: 24px; line-height: 1.8; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">

            {{-- Header warna dinamis sesuai status --}}
            <div class="{{ $pendaftaran->status == 'diterima' ? 'header-diterima' : 'header-ditolak' }}">
                <div class="header-logo">PT Global Intermedia Nusantara</div>
                <div class="header-title">
                    @if ($pendaftaran->status == 'diterima')
                        🎉 Selamat, Anda Diterima!
                    @else
                        📋 Hasil Seleksi Magang
                    @endif
                </div>
            </div>

            {{-- Body --}}
            <div class="body">
                <p class="greeting">
                    Halo <strong>{{ $pendaftaran->user->name }}</strong>,<br>
                    Berikut adalah pembaruan terbaru mengenai status pendaftaran magang Anda di
                    <strong>PT Global Intermedia Nusantara</strong>.
                </p>

                {{-- Status Badge --}}
                <div class="status-wrap">
                    <span class="status-badge {{ $pendaftaran->status == 'diterima' ? 'status-diterima' : 'status-ditolak' }}">
                        {{ $pendaftaran->status == 'diterima' ? '✅ DITERIMA' : '❌ DITOLAK' }}
                    </span>
                </div>

                {{-- Catatan Admin --}}
                <div class="{{ $pendaftaran->status == 'diterima' ? 'note-box-diterima' : 'note-box-ditolak' }}">
                    <span class="note-label">📝 Catatan dari HRD</span>
                    {{ $pendaftaran->catatan_admin }}
                </div>

                {{-- Detail Pendaftar --}}
                <div class="detail-card">
                    <div class="detail-title">📋 Data Pendaftaran Anda</div>

                    <div class="detail-row">
                        <span class="detail-label">Kode Pendaftaran</span>
                        <span class="detail-value" style="font-family: monospace; letter-spacing: 2px; color: #dc2626;">
                            {{ $pendaftaran->kode_pendaftaran }}
                        </span>
                    </div>

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

                {{-- Pesan Lanjutan --}}
                @if ($pendaftaran->status == 'diterima')
                    <div class="info-diterima">
                        🎓 <strong>Selamat!</strong> Silakan login ke dashboard Anda untuk mengunduh
                        <strong>Surat Penerimaan / LoA</strong> dan serahkan kepada instansi Anda sebagai bukti penerimaan magang.
                        Kami akan menghubungi Anda lebih lanjut mengenai persiapan sebelum magang dimulai.
                    </div>
                @else
                    <div class="info-ditolak">
                        💪 Tetap semangat! Jangan berkecil hati dan terus kembangkan kemampuan Anda.
                        Kami sangat menghargai ketertarikan Anda terhadap program magang di perusahaan kami.
                        Silakan coba kembali pada periode pendaftaran berikutnya.
                    </div>
                @endif

                <p class="salutation">
                    Salam hangat,<br>
                    <strong>Tim HRD PT Global Intermedia Nusantara</strong>
                </p>
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