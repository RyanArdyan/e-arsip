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
        // masukkan data baris ke table kategori_dokumen
        // panggil database, table kategori_dokumen lalu masukkan
        DB::table('kategori_dokumen')->insert([
            'nama' => 'Kekarantinaan & Surveilans',
            'jenis' => 'Teknis',
            'deskripsi' => 'Sertifikat Sanitasi Kapal, Deklarasi Kesehatan.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('kategori_dokumen')->insert([
            'nama' => 'Pengendalian Risiko Lingkungan',
            'jenis' => 'Teknis',
            'deskripsi' => 'Laporan Fogging, Pemeriksaan Jentik.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('kategori_dokumen')->insert([
            'nama' => 'Administrasi Umum',
            'jenis' => 'Umum',
            'deskripsi' => 'Absensi, Surat Tugas, Nota Dinas.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('kategori_dokumen')->insert([
            'nama' => 'Keuangan',
            'jenis' => 'Keuangan',
            'deskripsi' => 'Laporan Keuangan, SPJ, Kwitansi.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('kategori_dokumen')->insert([
            'nama' => 'Dokumen SDM',
            'jenis' => 'Kepegawaian',
            'deskripsi' => 'SK Pegawai, Penilaian Kinerja.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
