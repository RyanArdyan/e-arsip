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
        Schema::create('users', function (Blueprint $table) {
            // The bigIncrements method creates an auto-incrementing UNSIGNED BIGINT (primary key) equivalent column
            $table->bigIncrements('user_id');

            // membuat foreign key
            $table->unsignedBigInteger('kantor_id');
            // kunci asing adalah column kantor_id, referensi nya adalah column kantor_id di table kantor
            $table->foreign('kantor_id')->references('kantor_id')->on('kantor');

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // 1. super_admin → admin kantor pusat → bisa CRUD kantor, user, kategori dokumen, dll
            // 2. admin → admin kantor cabang → hanya bisa mengelola user & dokumen di cabangnya sendiri
            // 3. staff → hanya upload & melihat dokumen miliknya
            // Kalau hanya pakai role admin, semua admin cabang bisa CRUD kantor → berbahaya.
            $table->enum('peran', ['super_admin', 'admin', 'staff']);
            // Lokasi file gambar tanda tangan admin (misal: `signatures/admin_budi.png`
            $table->string('jalur_gambar_tanda_tangan')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
