<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriDokumenModel extends Model
{
    use HasFactory;

    // nama table
    protected $table = 'kategori_dokumen';
    // nama primary key
    protected $primaryKey = 'kategori_dokumen_id';
    // agar bisa menambahkan dan memperbarui data secara masal
    protected $guarded = [];

    /**
     * Relasi ke tabel dokumen
     * Ditambahkan parameter kedua: 'kategori_dokumen_id' (Foreign Key di tabel dokumen)
     * Ditambahkan parameter ketiga: 'kategori_dokumen_id' (Primary Key di tabel kategori_dokumen)
     */
    public function dokumen() {
        return $this->hasMany(Dokumen::class, 'kategori_dokumen_id', 'kategori_dokumen_id');
    }
}
