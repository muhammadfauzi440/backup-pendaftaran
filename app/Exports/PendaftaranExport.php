<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class PendaftaranExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $search;
    protected $status;

    public function __construct($search = null, $status = null)
    {
        $this->search = $search;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Pendaftaran::with(['user', 'instansi'])->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('user', function($subQ) {
                    $subQ->where('name', 'like', "%{$this->search}%");
                })->orWhere('nim_nisn', 'like', "%{$this->search}%");
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Pendaftaran',
            'Tipe Pendaftaran',
            'Nama Pendaftar / Ketua',
            'Email',
            'No. HP / WA',
            'Jenis Kelamin',
            'Tempat, Tanggal Lahir',
            'Agama',
            'Alamat Lengkap',
            'Kategori',
            'Instansi / Kampus / Sekolah',
            'NIM / NISN',
            'Jurusan / Program Studi',
            'Kelas / Semester',
            'Mulai Magang',
            'Selesai Magang',
            'Durasi (Bulan)',
            'Status',
            'Catatan Admin',
            'Waktu Pendaftaran',
        ];
    }

    public function map($p): array
    {
        return [
            $p->id,
            $p->kode_pendaftaran,
            ucfirst($p->tipe_pendaftaran),
            $p->user->name ?? '-',
            $p->user->email ?? '-',
            "'" . $p->kontak,
            $p->jenis_kelamin == 'laki-laki' ? 'Laki-Laki' : 'Perempuan',
            $p->tempat_lahir . ', ' . Carbon::parse($p->tanggal_lahir)->format('d F Y'),
            $p->agama,
            $p->alamat,
            ucfirst($p->kategori),
            $p->nama_instansi_display,
            "'" . $p->nim_nisn,
            $p->jurusan,
            $p->kelas_semester,
            Carbon::parse($p->tanggal_mulai)->format('d-m-Y'),
            Carbon::parse($p->tanggal_selesai)->format('d-m-Y'),
            $p->durasi_bulan,
            strtoupper($p->status),
            $p->catatan_admin ?? '-',
            Carbon::parse($p->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}