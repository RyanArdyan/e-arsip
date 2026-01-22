<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// panggil seeder/benih agar data baris ditambahkan ke table kantor
use Database\Seeders\KantorSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // untuk memanggil seeder tambahan seperti KantorSeeder
        $this->call([
            // panggil KantorSeeder
            KantorSeeder::class,
            // panggil UserSeeder
            UserSeeder::class,
            // panggil KategoriDokumenSeeder
            KategoriDokumenSeeder::class,
        ]);

        // Membuat 1 Admin
        // panggil UserFactory lalu method admin untuk membuat user dengan peran admin
        User::factory()->admin()->create();

        // Membuat 15 Staff
        User::factory(15)->staff()->create();
    }
}
