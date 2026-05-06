<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendaftaran Magang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .header p {
            margin: 2px 0;
            font-size: 9px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 4px;
            text-align: left;
            word-wrap: break-word; /* Mencegah teks panjang merusak tabel */
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .status-diterima { color: #059669; }
        .status-pending { color: #d97706; }
        .status-ditolak { color: #dc2626; }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 8px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Pendaftaran Magang</h2>
        <p>PT Global Intermedia Nusantara</p>
        <p>Total Data: {{ $pendaftarans->count() }} Pendaftar | Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="8%">Kode & Tipe</th>
                <th width="12%">Nama Lengkap</th>
                <th width="10%">Kontak & L/P</th>
                <th width="12%">TTL & Agama</th>
                <th width="15%">Instansi & Kategori</th>
                <th width="10%">NIM/NISN & Kelas</th>
                <th width="10%">Jurusan</th>
                <th width="12%">Periode Magang</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftarans as $index => $p)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    
                    <td>
                        <strong>{{ $p->kode_pendaftaran }}</strong><br>
                        <span style="color: #666;">{{ ucfirst($p->tipe_pendaftaran) }}</span>
                    </td>
                    
                    <td>
                        <strong>{{ $p->user->name ?? 'N/A' }}</strong><br>
                        <span style="color: #666;">{{ $p->user->email ?? 'N/A' }}</span>
                    </td>
                    
                    <td>
                        {{ $p->kontak }}<br>
                        <span style="color: #666;">{{ $p->jenis_kelamin == 'laki-laki' ? 'Laki-Laki' : 'Perempuan' }}</span>
                    </td>

                    <td>
                        {{ $p->tempat_lahir }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d/m/Y') }}<br>
                        <span style="color: #666;">{{ $p->agama }}</span>
                    </td>

                    <td>
                        <strong>{{ $p->nama_instansi_display }}</strong><br>
                        <span style="color: #666;">{{ ucfirst($p->kategori) }}</span>
                    </td>

                    <td>
                        <strong>{{ $p->nim_nisn }}</strong><br>
                        <span style="color: #666;">{{ $p->kelas_semester }}</span>
                    </td>

                    <td>{{ $p->jurusan }}</td>

                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d/m/Y') }}<br>
                        <span style="color: #666;">({{ $p->durasi_bulan }} Bulan)</span>
                    </td>

                    <td class="status status-{{ $p->status }}">
                        {{ strtoupper($p->status) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini di-generate secara otomatis oleh Sistem Pendaftaran PT Global Intermedia.</p>
    </div>
</body>

</html>