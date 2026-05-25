<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Instansi;
class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_instansi' => 'SMK Muhammadiyah 1 Bantul',
                'alamat_instansi' => 'Jl. Parangtritis KM 12 Manding, Trirenggo, Bantul',
                'kontak_instansi' => '(0274)367954',
                'tipe' => 'sekolah'
            ],
            [
                'nama_instansi' => 'SMK Negeri 1 Bantul',
                'alamat_instansi' => 'Jl. Parangtritis No.KM.11, Dukuh, Sabdodadi, Kec. Bantul, Kabupaten Bantul',
                'kontak_instansi' => '(0274) 367156',
                'tipe' => 'sekolah'
            ],
            [
                'nama_instansi' => 'Universitas Gadjah Mada',
                'alamat_instansi' => 'Bulaksumur, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta',
                'kontak_instansi' => '(0274)588688',
                'tipe' => 'universitas'
            ],
            [
                'nama_instansi' => 'UPN Veteran Yogyakarta',
                'alamat_instansi' => 'Jl. Padjajaran, Sleman, Yogyakarta',
                'kontak_instansi' => '(0274) 486733',
                'tipe' => 'universitas'
            ]
        ];

        foreach ($data as $item) 
        {
            Instansi::create($item);
        }
    }
}
