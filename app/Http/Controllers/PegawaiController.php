<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kantor;
use App\Models\User;

class PegawaiController extends Controller
{
    // jika ada value input name kantor_id maka request akan menangkap nilai nya
    public function index(Request $request)
    {
        // Ambil semua kantor untuk isi dropdown filter
        $semua_kantor = Kantor::all();

        // Query awal: Ambil user yang BUKAN super_admin
        // Tanpa with('kantor'), jika Anda memiliki 10 pegawai dan ingin menampilkan nama kantornya, Laravel akan melakukan query ke database sebanyak 11 kali:
        // ambil semua user yang berelasi dengan kantor dimana peran tidak sama dengan super_admin
        $query = User::with('kantor')->where('peran', '!=', 'super_admin');

        // Cek apakah ada filter kantor_id di URL atau user mengirimkan value input name="kantor_id"
        if ($request->filled('kantor_id')) {
            // berisi menangkap value input name="kantor_id"
            $kantor_id = $request->input('kantor_id');

            // jika ada input name="kantor_id" maka query lakukan pencarian dimana kantor_id sama dengan kantor_id yang dikirim
            // berarti ambil user yang kantor_id nya sama dengan value input name="kantor_id"
            $query->where('kantor_id', $kantor_id);
            // ambil detail kantor untuk menampilkan nama kantor di view
            $detail_kantor = Kantor::find($kantor_id);
        } else {
            // Jika tidak ada filter, default tampilkan semua atau kantor pusat
            $detail_kantor = (object)['nama' => 'Seluruh Cabang'];
        }

        // ambil pegawai dan lakukan paginasi 10 data per halaman
        $daftar_pegawai_yg_terkait_dgn_kantor = $query->paginate(10);

        // kembalikan ke tampilan lalu kirimkan data berikut:
        return view('super_admin.pegawai.index', compact(
            'daftar_pegawai_yg_terkait_dgn_kantor',
            'semua_kantor',
            'detail_kantor'
        ));
    }

    public function create($kantor_id = null)
    {
        // Jika ada kantor_id, ambil data detail kantornya untuk ditampilkan di form, kalau tidak ada maka null
        $kantor_terpilih = $kantor_id ? Kantor::find($kantor_id) : null;

        // Ambil semua kantor untuk pilihan dropdown di form
        $semua_kantor = Kantor::all();

        // kembalikkan ke tampilan berikut lalu kirimkan data berikut:
        return view('super_admin.pegawai.create', compact('kantor_terpilih', 'semua_kantor'));
    }

    // $pegawai_id berisi pegawai_id yang dikirim dari rute
    public function edit($pegawai_id)
    {
        // ambil detail pegawai
        $detail_peran = User::findOrFail($pegawai_id)->peran;

        // Kembali ke tampilan sambil mengirimkan data
        return view('super_admin.kantor.daftar_pegawai.edit', [
            // column detail_peran akan berisi data dari variabel $detail_peran
            'detail_peran' => $detail_peran
        ]);
    }
}
