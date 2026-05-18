<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Instansi;
use App\Models\Pendaftaran;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            InstansiSeeder::class,
            AdminSeeder::class,
        ]);

        $instansis = Instansi::all();

        if ($instansis->isEmpty()) {
            $this->command->error("Instansi kosong! Pastikan InstansiSeeder sudah benar.");
            return;
        }

        $daftarStatus = ['pending', 'diterima', 'ditolak'];
        foreach ($daftarStatus as $status) {
            $user = User::create([
                'name' => 'Pendaftar ' . ucfirst($status),
                'email' => "user_$status@gmail.com",
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]);

            Pendaftaran::create([
                'user_id'         => $user->id,
                'instansi_id'     => $instansis->random()->id,
                'kode_pendaftaran'=> 'GIN-DEMO-' . strtoupper($status),
                'kategori'        => rand(0, 1) ? 'siswa' : 'mahasiswa',

                'nim_nisn'        => rand(10000000, 99999999),
                'jurusan'         => 'Teknik Informatika',
                'tanggal_mulai'   => now()->addDays(14),
                'tanggal_selesai' => now()->addMonths(4),
                'durasi_bulan'    => 4,
                'tempat_lahir'    => 'Yogyakarta',
                'tanggal_lahir'   => '2004-01-01',
                'alamat'          => 'Jl Pegangsaan Timur',
                'jenis_kelamin'   => 'laki-laki',

                'kontak'          => '081234567' . rand(100, 999),
                'status'          => $status,
                'catatan_admin'   => $status === 'pending' ? null : 'Catatan demo ' . $status,
            ]);
        }

        Pendaftaran::factory()->count(50)->create();
        
        $this->command->info("Berhasil membuat 50 data dummy Pendaftaran!");
    }
}