<?php

namespace Database\Factories;

use App\Models\Instansi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instansi>
 */
class InstansiFactory extends Factory
{
    protected $model = Instansi::class;

    public function definition(): array
    {
        $tipe = $this->faker->randomElement(['sekolah', 'universitas']);

        $namaSekolah = [
            'SMK Negeri', 'SMK Muhammadiyah', 'SMA Negeri', 'SMK PGRI', 'SMK Telkom',
            'SMK Bina Patria', 'SMK Nasional', 'SMK Karya Rini', 'SMK YPKK', 'SMK 17'
        ];
        $namaUniversitas = [
            'Universitas', 'Politeknik', 'Institut Teknologi', 'Sekolah Tinggi Ilmu',
            'Akademi Komunitas', 'STMIK', 'STIE', 'AMIKOM', 'AMIK'
        ];

        $kota = $this->faker->randomElement([
            'Yogyakarta', 'Sleman', 'Bantul', 'Gunung Kidul', 'Kulon Progo',
            'Magelang', 'Purworejo', 'Wonosari', 'Klaten'
        ]);

        if ($tipe === 'sekolah') {
            $nama = $this->faker->randomElement($namaSekolah) . ' ' . $this->faker->numberBetween(1, 5) . ' ' . $kota;
        } else {
            $nama = $this->faker->randomElement($namaUniversitas) . ' ' . $kota;
        }

        return [
            'nama_instansi'    => $nama,
            'alamat_instansi'  => $this->faker->streetAddress() . ', ' . $kota . ', Yogyakarta',
            'kontak_instansi'  => $this->faker->numerify('(0274) ######'),
            'tipe'             => $tipe,
        ];
    }
}
