<?php

namespace App\Http\Controllers;

use App\Models\KategoriDokumenModel;
use Illuminate\Http\Request;

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

    // parameter $kategori_dokumen_id akan menerima kategori_dokumen_id dari url atau rute
    public function detail($kategori_dokumen_id)
    {
        // 1. Mengambil detail data kategori_dokumen berdasarkan kategori_dokumen_id
        $detail_kategori = KategoriDokumenModel::findOrFail($kategori_dokumen_id);

        // 2. Mengirim data kategori ke View detail
        return view('super_admin.kategori.detail', ['detail_kategori' => $detail_kategori]);
    }

    public function create()
    {
        return view('super_admin.kategori.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            // input name="nama" harus diisi, bertipe string, maksimal 255 karakter
            'nama' => 'required|string|max:255',
            // jenis harus diisi dan salah satu dari pilihan berikut
            'jenis' => 'required|in:Teknis,Keuangan,Kepegawaian,Umum',
            'deskripsi' => 'nullable|string',
        ]);

        // 2. Simpan ke Database, table kategori_dokumen
        KategoriDokumenModel::create([
            // dari column nama di database diisi dengan data dari request input nama
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
        ]);

        // 3. Redirect alihkan ke rute berikut dengan sesi pesan sukses
        return redirect()->route('manajemen.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman form edit
     */
    public function edit($kategori_id)
    {
        // Mencari data berdasarkan primary key, jika tidak ketemu akan error 404
        $detail_kategori = KategoriDokumenModel::findOrFail($kategori_id);

        // Mengirim data kategori ke view 'super_admin.kategori.edit', kirimkan data dengan nama 'detail_kategori'
        return view('super_admin.kategori.edit', ['detail_kategori' => $detail_kategori]);
    }

    /**
     * Memproses pembaruan data ke database
     * $request berisi semua value input name
     * $kategori_id adalah kategori_id yang dikirim dari URL
     */
    public function update(Request $request, $kategori_id)
    {
        // 1. Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:Teknis,Keuangan,Kepegawaian,Umum',
            'deskripsi' => 'nullable|string',
        ]);

        // 2. Cari data yang akan diupdate
        $kategori = KategoriDokumenModel::findOrFail($kategori_id);

        // 3. Eksekusi pembaruan
        $kategori->update([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
        ]);

        // 4. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('manajemen.kategori.index')->with('success', 'Kategori '.$kategori->nama.' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // coba lakukan
        try {
            // 1. Cari data berdasarkan ID
            $kategori = KategoriDokumenModel::findOrFail($id);

            // 2. Cek apakah kategori masih digunakan oleh dokumen lain (Opsional/Penting)
            // Jika ada relasi, sebaiknya cegah penghapusan agar tidak error (Integrity Constraint)
            if ($kategori->dokumen()->exists()) {
                // kembali alihkan kembali dengan pesan error berikut
                return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki dokumen terkait.');
            }

            // 3. Eksekusi penghapusan
            $kategori->delete();

            // 4. Redirect dengan pesan sukses dengan pesan sesi yg di flash
            return redirect()->route('manajemen.kategori.index')->with('success', 'Kategori dokumen berhasil dihapus.');

        }
        // kecuali jika terjadi error maka error akan ditangkap oleh $e
        catch (\Exception $e) {
            // Penanganan jika terjadi error sistem
            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
