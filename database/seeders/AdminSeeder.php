<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // updateOrInsert: Cek apakah email ada? 
        // Jika ada -> update data
        // Jika tidak ada -> buat baru

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gmail.com'], // Kunci pengecekan (biar gak duplikat)
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'is_admin' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}