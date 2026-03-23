<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaPendaftaran extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'nama',
        'nim_nisn',
        'jurusan',
        'jenis_kelamin',
        'kontak',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kelas_semester',
        'alamat',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
