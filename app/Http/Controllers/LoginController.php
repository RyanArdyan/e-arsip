<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// untuk berinteraksi dengan database
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        // jika autentikasi mengecek user sudah login maka alihkan
        if (Auth::check()) {
            // kembali alihkkan ke rute dashboard.index
            return redirect()->route('dashboard.index');
        }

        // kembali ke tampilan berikut
        return view('auth.login');
    }

    public function autentikasi(Request $request)
    {
        // validasi input value name=""
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        // jika data inut yang email dan password sesuai dengan database
        if (Auth::attempt($credentials, $request->remember)) {
            // regenerasi session
            $request->session()->regenerate();

            // alihkan ke url dashboard
            return redirect()->intended('/dashboard');
        }

        // jika data tidak sesuai dengan database atau login gagal
        return back()->withErrors([
            'email' => 'Email atau password yang anda masukkan salah.',
        ])
        // mengirimkan data ketikan input email misalnya itachi uchiha
        ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // autentikasi lakukan logout
        Auth::logout();

        $request->session()->invalidate();

        // permintaan sesi, hasilkan ulang token
        $request->session()->regenerateToken();

        // kembali alihkan ke url awal
        return redirect('/');
    }
}
