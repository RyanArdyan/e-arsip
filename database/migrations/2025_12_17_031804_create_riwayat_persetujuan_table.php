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
        Schema::create('riwayat_persetujuan', function (Blueprint $table) {
            $table->bigIncrements('riwayat_persetujuan_id');

            // membuat foreign key
            $table->unsignedBigInteger('dokumen_id');
            // kunci asing adalah column dokumen_id, referensi nya adalah column dokumen_id di table dokumen
            $table->foreign('dokumen_id')->references('dokumen_id')->on('dokumen');

            // membuat foreign key
            $table->unsignedBigInteger('pengubah_status_id');
            // kunci asing adalah column pengubah_status_id, referensi nya adalah column user_id di table users
            $table->foreign('pengubah_status_id')->references('user_id')->on('users');

            $table->enum('status_sebelummnya', ['Menunggu Persetujuan', 'Disetujui', 'Ditolak'])->nullable();

            $table->enum('status_baru', ['Menunggu Persetujuan', 'Disetujui', 'Ditolak']);

            // Misalnya, "Dokumen Tidak Lengkap" atau "Dokumen disetujui, siap untuk TTD digital."
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_persetujuan');
    }
};
