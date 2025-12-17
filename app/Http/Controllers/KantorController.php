<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kantor;

class KantorController extends Controller
{
    // Menampilkan daftar semua kantor dengan paginasi.
    public function index()
    {
        // 1. Mengambil data Kantor dan memaginasi (misalnya, 10 item per halaman)
        $kantor = Kantor::paginate(10);

        // 2. Mengirim data kantor yang sudah dipaginasi ke View
        return view('super_admin.kantor.index', ['semua_kantor' => $kantor]);
    }

    // parameter $kantor_id akan menerima kantor_id dari url atau rute
    public function detail($kantor_id)
    {
        // 1. Mengambil detail data Kantor berdasarkan kantor_id
        $detail_kantor = Kantor::findOrFail($kantor_id);

        // 2. Mengirim data kantor ke View detail
        return view('super_admin.kantor.detail', ['detail_kantor' => $detail_kantor]);
    }
}
