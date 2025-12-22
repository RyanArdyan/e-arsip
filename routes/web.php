<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\KategoriDokumenController;

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


// rute yang dilindungi (hanya bisa diakses setelah login)
Route::middleware(['auth'])->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // profile - menampilkan form edit profile
    Route::get('/profile/edit', [UserController::class, 'edit_profile'])->name('profile.edit');
    // rute tipe perbarui, jika user diarahkan ke url berikut maka ke controller dan method berikut, name nya adalah sebagai berikut
    Route::put('/profile/update', [UserController::class, 'update_profile'])->name('profile.update');
});

// Rute yang HANYA boleh diakses oleh Super Admin
// prefix manajamen berarti setiap url akan diawali oleh /manajemen
// name manajemen. berarti setiap name rute akan diawali oleh manajemen.
Route::prefix('manajemen')->name('manajemen.')->middleware(['auth'])->group(function () {
    // Gunakan Gate 'isSuperAdmin'
    Route::middleware('can:isSuperAdmin')->group(function () {
        // jika user di url /kantor maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::get('/kantor', [KantorController::class, 'index'])->name('kantor.index');
        // jika user di url berikut maka kirimkan /{kantor_id} lalu ke controller dan method berikut, name nya adalah sebagai berikut
        Route::get('/kantor/detail/{kantor_id}', [KantorController::class, 'detail'])->name('kantor.detail');
        // jika user di url /kantor/create maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::get('/kantor/create', [KantorController::class, 'create'])->name('kantor.create');
        // rute tipe store, jika user diarahkan ke url berikut maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::post('/kantor/store', [KantorController::class, 'store'])->name('kantor.store');
        // jika user di url manajemen/kantor/edit/{kantor_id} maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::get('/kantor/edit/{kantor_id}', [KantorController::class, 'edit'])->name('kantor.edit');
        // rute tipe perbarui, jika user diarahkan ke url berikut maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::put('/kantor/update/{kantor_id}', [KantorController::class, 'update'])->name('kantor.update');
        // rute tipe hapus, jika user diarahkan ke url berikut maka kirimkan kantor_id ke controller dan method berikut, name nya adalah sebagai berikut
        Route::delete('/kantor/delete/{kantor_id}', [KantorController::class, 'destroy'])->name('kantor.destroy');

        // jika user di url /kategori maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::get('/kategori', [KategoriDokumenController::class, 'index'])->name('kategori.index');
        // jika user di url berikut maka kirimkan /{kategori_id} lalu ke controller dan method berikut, name nya adalah sebagai berikut
        Route::get('/kategori/detail/{kategori_id}', [KategoriDokumenController::class, 'detail'])->name('kategori.detail');
        // jika user di url /kategori/create maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::get('/kategori/create', [KategoriDokumenController::class, 'create'])->name('kategori.create');
        // rute tipe store, jika user diarahkan ke url berikut maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::post('/kategori/store', [KategoriDokumenController::class, 'store'])->name('kategori.store');
        // jika user di url manajemen/kategori/edit/{kategori_id} maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::get('/kategori/edit/{kategori_id}', [KategoriDokumenController::class, 'edit'])->name('kategori.edit');
        // rute tipe perbarui, jika user diarahkan ke url berikut maka ke controller dan method berikut, name nya adalah sebagai berikut
        Route::put('/kategori/update/{kategori_id}', [KategoriDokumenController::class, 'update'])->name('kategori.update');
        // rute tipe hapus, jika user diarahkan ke url berikut maka kirimkan kategori_id ke controller dan method berikut, name nya adalah sebagai berikut
        Route::delete('/kategori/delete/{kategori_id}', [KategoriDokumenController::class, 'destroy'])->name('kategori.destroy');
    });

    // Gunakan Gate 'isAdmin' (Admin Cabang & Super Admin)
    Route::middleware('can:isAdmin')->group(function () {
        // CRUD User, Persetujuan Dokumen, dll.
    });
});


