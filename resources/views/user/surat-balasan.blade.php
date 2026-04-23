<!DOCTYPE html>
<html>
<head>
    <title>Surat Balasan Magang</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; line-height: 1.6; font-size: 12pt; margin: 40px; }
        .kop-surat { text-align: center; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 18pt; text-transform: uppercase; }
        .kop-surat p { margin: 0; font-size: 10pt; }
        .isi-surat { margin-top: 30px; text-align: justify; }
        .ttd { margin-top: 50px; float: right; width: 250px; text-align: center; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h1>PT GLOBAL INTERMEDIA NUSANTARA</h1>
        <p>Jl. Taman Siswa No.125 Yogyakarta 55151 | Telp: +62 817-456-225</p>
        <p>Email: admin@gi.com | Website: gi.co.id</p>
    </div>

    <div style="text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 30px;">
        SURAT BALASAN PENERIMAAN MAGANG
    </div>

    <div class="isi-surat">
        <p>Dengan hormat,</p>
        <p>Menanggapi permohonan pendaftaran magang/praktik kerja industri yang diajukan ke perusahaan kami, maka dengan ini kami menyatakan bahwa:</p>
        
        <table style="margin-left: 30px; margin-bottom: 15px;">
            <tr><td width="150">Nama Lengkap</td><td>: <strong>{{ $user->name }}</strong></td></tr>
            <tr><td>Kode Pendaftaran</td><td>: {{ $pendaftaran->kode_pendaftaran }}</td></tr>
            <tr><td>Instansi / Kampus</td><td>: {{ $pendaftaran->instansi->nama_instansi ?? '-' }}</td></tr>
            <tr><td>Program Studi</td><td>: {{ $pendaftaran->jurusan }}</td></tr>
        </table>

        <p>Telah kami setujui dan <strong>DITERIMA</strong> untuk melaksanakan program magang di PT Global Intermedia Nusantara, terhitung mulai tanggal <strong>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai)->translatedFormat('d F Y') }}</strong> hingga <strong>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai)->translatedFormat('d F Y') }}</strong>.</p>

        <p>Catatan dari Admin: <em>{{ $pendaftaran->catatan_admin ?? 'Silakan menghadap ke instruktur pada hari pertama magang.' }}</em></p>

        <p>Demikian surat balasan ini kami sampaikan agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <p>Yogyakarta, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Pimpinan Instruktur,</p>
        <br><br><br>
        <p><strong><u>HRD Manager</u></strong></p>
    </div>
</body>
</html>