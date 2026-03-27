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
            'Nama Pendaftar',
            'email',
            'Instansi',
            'Kategori',
            'NIM/NISN',
            'Jurusan',
            'Durasi (Bulan)',
            'Mulai Magang',
            'Selesai Magang',
            'Status',
            'Waktu Submit',
        ];
    }

    public function map($p): array
    {
        return [
            $p->id,
            $p->user->name ?? '-',
            $p->user->email ?? '-',
            $p->instansi->nama_instansi ?? '-',
            ucfirst($p->kategori),
            "'" . $p->nim_nisn,
            $p->jurusan,
            $p->durasi_bulan,
            Carbon::parse($p->tanggal_mulai)->format('d-m-Y'),
            Carbon::parse($p->tanggal_selesai)->format('d-m-Y'),
            strtoupper($p->status),
            Carbon::parse($p->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}