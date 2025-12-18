<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    // nama table
    protected $table = 'dokumen';
    // nama primary key
    protected $primaryKey = 'dokumen_id';
    // agar bisa menambahkan dan memperbarui data secara masal
    protected $guarded = [];
}
