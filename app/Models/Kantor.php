<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kantor extends Model
{
    use HasFactory;

    // nama table
    protected $table = 'kantor';
    // nama primary key
    protected $primaryKey = 'kantor_id';
    // agar bisa menambahkan dan memperbarui data secara masal
    protected $guarded = [];

    /**
     * Relasi ke tabel Users
     * Ditambahkan parameter kedua: 'kantor_id' (Foreign Key di tabel users)
     * Ditambahkan parameter ketiga: 'kantor_id' (Primary Key di tabel kantor)
     */
    public function users() {
        return $this->hasMany(User::class, 'kantor_id', 'kantor_id');
    }

    /**
     * Relasi ke tabel Dokumen
     * Ditambahkan parameter kedua: 'kantor_id' (Foreign Key di tabel dokumen)
     */
    public function dokumen() {
        return $this->hasMany(Dokumen::class, 'kantor_id', 'kantor_id');
    }
}
