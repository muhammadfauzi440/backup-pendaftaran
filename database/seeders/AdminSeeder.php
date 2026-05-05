<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gi.com'],
            [
                'name' => 'Admin GI',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'testing@gmail.com'],
            [
                'name' => 'User Global Intermedia',
                'password' => bcrypt('123456'),
                'role' => 'user',
            ]
        );
    }
}
