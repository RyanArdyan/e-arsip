<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kantor;
use App\Http\Requests\StoreKantorRequest;
use Illuminate\Support\Facades\Log;

class KantorController extends Controller
{
    // Menampilkan daftar semua kantor dengan paginasi.
    public function index()
    {
        // 1. Mengambil data Kantor dan memaginasi (misalnya, 10 item per halaman)
        // Mengurutkan berdasarkan 'created_at' terbaru ke terlama, lalu bagi 10 per halaman
        $kantor = Kantor::latest()->paginate(10);

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

    public function create()
    {
        // Menampilkan form untuk membuat kantor baru
        return view('super_admin.kantor.tambah');
    }

    /**
     * Simpan kantor baru.
     */
    public function store(StoreKantorRequest $request)
    {
        // Otorisasi dan Validasi sudah dilakukan di StoreKantorRequest.

        // Ambil data yang sudah lolos validasi
        $validatedData = $request->validated();

        try {
            // Membuat dan menyimpan record baru
            $kantor = Kantor::create($validatedData);

            // 3. Redirect kembali ke halaman daftar kantor atau halaman form
            // Kita sertakan 'success' sebagai pesan kilat (session flash)
            return redirect()->route('manajemen.kantor.index')->with('success', 'Kantor berhasil dibuat.');

        } catch (\Exception $e) {
            // Log error untuk debugging internal
            \Log::error("Gagal membuat kantor: " . $e->getMessage());

            // Jika gagal, kembali ke halaman sebelumnya dengan pesan error
            return back()->withInput() // Menjaga agar input user tidak hilang
                     ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
}
