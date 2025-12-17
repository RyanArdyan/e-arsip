<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// import database
use Illuminate\Support\Facades\DB;
// agar bisa berinteraksi dengan table kantor
use App\Models\Kantor;

class KantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // masukkan data baris ke table users
        // panggil database, table kantor lalu masukkan
        DB::table('kantor')->insert([
            'nama' => 'Balai Kekarantinaan Kesehatan Kelas I Pontianak',
            'alamat' => 'Jl. Jenderal Ahmad Yani, Arang Limbung, Kec. Sungai Raya, Kabupaten Kubu Raya, Kalimantan Barat 78391',
            'tipe' => 'pusat',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Membuat 15 data kantor lain secara acak menggunakan Factory
        // Pastikan Anda telah menambahkan 'use HasFactory' di Model Kantor.
        Kantor::factory()->count(15)->create();
    }
}
