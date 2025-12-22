<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriDokumenModel;

class KategoriDokumenController extends Controller
{
    // Menampilkan daftar semua kantor dengan paginasi.
    public function index()
    {
        // 1. Mengambil data kategori dan memaginasi (misalnya, 10 item per halaman)
        // Mengurutkan berdasarkan 'created_at' terbaru ke terlama, lalu bagi 10 per halaman
        $kategori = KategoriDokumenModel::latest()->paginate(10);

        // 2. Mengirim data kategori yang sudah dipaginasi ke View
        return view('super_admin.kategori.index', ['semua_kategori' => $kategori]);
    }

    public function detail($kategori_id)
    {
        //
    }
}
