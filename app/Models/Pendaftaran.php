<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Dokumen;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
class Pendaftaran extends Model
{
    protected $guarded = ['id'];
    protected $table = 'pendaftarans';
    protected $fillable = [
        'user_id',
        'instansi_id',
        'kode_pendaftaran',
        'tipe_pendaftaran',
        'kategori',
        'nim_nisn',
        'kelas_semester',
        'jurusan',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_bulan',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jenis_kelamin',
        'agama',
        'kontak',
        'status',
        'catatan_admin'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_lahir' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'User Tidak Ditemukan',
            'email' => 'Email Tidak Ditemukan'
        ]);
    }

    public function instansi() 
    {
        return $this->belongsTo(Instansi::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'pendaftaran_id');
    }

    public function anggota()
    {
        return $this->hasMany(AnggotaPendaftaran::class, 'pendaftaran_id');
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function($pendaftaran){
            if (empty($pendaftaran->kode_pendaftaran)) {
                $pendaftaran->kode_pendaftaran = 'GIN-' . strtoupper(str()->random(8));
            }
        });
    }
}
