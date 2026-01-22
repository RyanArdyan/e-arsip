<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriDokumenModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen extends Model
{
    // nama table
    protected $table = 'dokumen';
    // nama primary key
    protected $primaryKey = 'dokumen_id';
    // agar bisa menambahkan dan memperbarui data secara masal
    protected $guarded = [];

    public function kategoriDokumen()
    {
        return $this->belongsTo(KategoriDokumenModel::class, 'kategori_dokumen_id', 'kategori_dokumen_id');
    }
}
