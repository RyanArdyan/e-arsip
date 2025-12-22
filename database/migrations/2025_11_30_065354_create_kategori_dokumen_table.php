<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agar dokumen tidak tercampur, sebaiknya dikategorikan (misal: Laporan Keuangan, Surat Jalan, Absensi).
        Schema::create('kategori_dokumen', function (Blueprint $table) {
            // The bigIncrements method creates an auto-incrementing UNSIGNED BIGINT (primary key) equivalent column
            $table->bigIncrements('kategori_dokumen_id');
            $table->string('nama');
            $table->enum('jenis', ['Teknis', 'Keuangan', 'Kepegawaian', 'Umum']);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_dokumen');
    }
};
