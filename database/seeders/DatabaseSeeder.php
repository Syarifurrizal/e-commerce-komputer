<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Penjual (Admin)
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Akun Pembeli Biasa
        User::create([
            'name' => 'Syarifur Rizal',
            'email' => 'pembeli@toko.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}