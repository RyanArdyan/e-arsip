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
}
