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
        Schema::create('dokumen', function (Blueprint $table) {
            // The bigIncrements method creates an auto-incrementing UNSIGNED BIGINT (primary key) equivalent column
            $table->bigIncrements('dokumen_id');

            // membuat foreign key
            $table->unsignedBigInteger('user_id');
            // kunci asing adalah column user_id, referensi nya adalah column user_id di table users
            $table->foreign('user_id')->references('user_id')->on('users');

            // membuat foreign key
            $table->unsignedBigInteger('kantor_id');
            // kunci asing adalah column kantor_id, referensi nya adalah column kantor_id di table kantor
            $table->foreign('kantor_id')->references('kantor_id')->on('kantor');

            // membuat foreign key
            $table->unsignedBigInteger('kategori_dokumen_id');
            // kunci asing adalah column kategori_dokumen_id, referensi nya adalah column kategori_dokumen_id di table kategori_dokumen
            $table->foreign('kategori_dokumen_id')->references('kategori_dokumen_id')->on('kategori_dokumen');

            // membuat foreign key
            $table->unsignedBigInteger('tanda_tangan_yg_menyetujui_id');
            // kunci asing adalah column tanda_tangan_yg_menyetujui_id, referensi nya adalah column tanda_tangan_yg_menyetujui_id di table kategori_dokumen
            $table->foreign('tanda_tangan_yg_menyetujui_id')->references('user_id')->on('users' );

            $table->string('judul_dokumen');
            // file asli yang di upload kantor cabang (polos)
            $table->string('jalur_file_asli');
            // file pdf yang sudah ada qr & tanda tangan nya. diisi setelah di setujui
            $table->string('jalur_file_yang_sudah_ditandatangan')->nullable();
            $table->uuid('token_validasi');
            $table->enum('status', ['Menunggu Persetujuan', 'Disetujui', 'Ditolak'])->default('Menunggu Persetujuan');
            // nullable berarti boleh kosong
            $table->text('alasan_ditolak')->nullable();

            // membuat foreign key
            $table->unsignedBigInteger('disetujui_oleh');
            // kunci asing nya adalah column disetujui_oleh, referensi nya adalah column user_id di table users
            $table->foreign('disetujui_oleh')->references('user_id')->on('users');

            // Sangat disarankan. Berguna untuk memastikan integritas dokumen. Jika dokumen aslinya diubah setelah diunggah, hash-nya akan berbeda.
            $table->char('hash_dokumen_asli', length: 64);

            // Sangat disarankan. Digunakan saat pemindaian QR Code untuk memverifikasi bahwa file yang diakses sama persis dengan file yang tervalidasi di sistem.
            $table->char('hash_dokumen_ditandatangan', length: 64)->nullable();

            // contoh: 2025-12-30 20:00:00
            $table->timestamp('disetujui_pada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
