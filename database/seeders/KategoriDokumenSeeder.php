<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// import database
use Illuminate\Support\Facades\DB;
// agar bisa berinteraksi dengan table KategoriDokumenModel
use App\Models\KategoriDokumenModel;

class KategoriDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // masukkan data baris ke table users
        // panggil database, table kategori_dokumen lalu masukkan
        DB::table('kategori_dokumen')->insert([
            'nama' => 'Balai Kekarantinaan Kesehatan Kelas I Pontianak',
            'alamat' => 'Jl. Jenderal Ahmad Yani, Arang Limbung, Kec. Sungai Raya, Kabupaten Kubu Raya, Kalimantan Barat 78391',
            'tipe' => 'pusat',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
