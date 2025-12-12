<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    // nama table
    protected $table = 'kantor';
    // nama primary key
    protected $primaryKey = 'kantor_id';
    // agar bisa menambahkan dan memperbarui data secara masal
    protected $guarded = [];
}
