<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kantor;
use App\Http\Requests\StoreKantorRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    // parameter $kantor_id akan menerima kantor_id dari url atau rute
    public function destroy($kantor_id)
    {
        // jika yang login adalah detail user, column peran nya tidak sama dengan super_admin
        if (Auth::user()->peran !== 'super_admin') {
            // kembali ke url sebelumnya lalu kirimkan pesan error menggunakan sesi flash
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus kantor.');
        }

        // 2. Cari data kantor
        // Fungsi ini akan menghitung secara otomatis berapa banyak jumlah User dan Dokumen yang terhubung ke kantor tersebut tanpa harus mengambil sem ua datanya. Ini sangat efisien bagi performa server.
        $kantor = Kantor::withCount(['users', 'dokumen'])->findOrFail($kantor_id);

        // 3. Cek apakah kantor masih memiliki User atau Dokumen
        // withCount akan menghasilkan atribut users_count dan dokumen_count
        if ($kantor->users_count > 0 || $kantor->dokumen_count > 0) {
            return back()->with('error', "Gagal menghapus! Kantor ini masih memiliki {$kantor->users_count} User dan {$kantor->dokumen_count} Dokumen. Hapus atau pindahkan data tersebut terlebih dahulu.");
        }

        // coba untuk menghapus kantor
        try {
            // detail kantor dihapus
            $kantor->delete();

            // kembali alihkan ke rute manajemen.kantor.index dengan pesan sukses
            return redirect()->route('manajemen.kantor.index')
                            ->with('success', 'Kantor berhasil dihapus.');

        }
        // jika terjadi error di block try maka akan ditangani di block catch
        catch (\Exception $e) {
            // Mencatat error teknis ke storage/logs/laravel.log
            \Log::error("Gagal hapus kantor ID {$kantor_id}: " . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan sistem saat mencoba menghapus data.');
        }
    }
}
