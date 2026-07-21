<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat User Admin Perpustakaan
        User::factory()->create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'admin@perpus.com',
            'password' => 'password123', // Tanpa bcrypt() agar tidak double-hash
        ]);
    }
}
