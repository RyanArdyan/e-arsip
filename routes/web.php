<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;

// login
// jika user di url awal maka ke controller dan method berikut, name nya adalah sebagai berikut
Route::get('/', [LoginController::class, 'index'])->name('login');
// untuk mengirimkan data ke database
Route::post('/login', [LoginController::class, 'autentikasi'])->name('login.autentikasi');

// registrasi
// get untu tampilan dan untuk mendapatkan data dari database
Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi.index');
// post untuk mengirimkan data ke database
Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// rute yang dilindungi (hanya bisa diakses setelah login)
Route::middleware(['auth'])->group(function () {
    // dashboard
});

// logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

