<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Panggil AdminSeeder agar akun admin dibuat
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
        ]);

        // 2. Buat user dummy lainnya (opsional)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
