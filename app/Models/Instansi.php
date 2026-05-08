<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pendaftaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansis';
    protected $fillable = [
        'nama_instansi',
        'alamat_instansi',
        'kontak_instansi',
        'tipe'
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
