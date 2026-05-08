<?php

namespace Database\Factories;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Instansi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendaftaran>
 */
class PendaftaranFactory extends Factory
{
    protected $model = Pendaftaran::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 week', '+1 month');
        $durasi = $this->faker->numberBetween(3, 6);
        $endDate = (clone $startDate)->modify("+$durasi months");

        return [
            'user_id' => User::factory(),
            'instansi_id' => Instansi::inRandomOrder()->first()->id ?? 1,
            'instansi_lain' => null,
            'kode_pendaftaran' => 'GIN-' . strtoupper(Str::random(10)),
            'tipe_pendaftaran' => $this->faker->randomElement(['individu', 'kelompok']),
            'kategori' => $this->faker->randomElement(['siswa', 'mahasiswa']),
            'nim_nisn' => $this->faker->unique()->numerify('########'),
            'kelas_semester' => $this->faker->randomElement(['Kelas 11', 'Kelas 12', 'Semester 5', 'Semester 7']),
            'jurusan' => $this->faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Rekayasa Perangkat Lunak', 'Multimedia']),
            'tanggal_mulai' => $startDate->format('Y-m-d'),
            'tanggal_selesai' => $endDate->format('Y-m-d'),
            'durasi_bulan' => $durasi,
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-25 years', '-17 years')->format('Y-m-d'),
            'alamat' => $this->faker->address(),
            'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
            'kontak' => $this->faker->numerify('081#########'),
            'status' => $this->faker->randomElement(['pending', 'diterima', 'ditolak']),
            'catatan_admin' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
