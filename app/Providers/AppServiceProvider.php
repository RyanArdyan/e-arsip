<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// untuk mengatur otorisasi seperti hanya super-admin yang bisa mengakses halaman tertentu seperti kantor
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tambahkan baris ini agar Laravel menggunakan styling Bootstrap 5
        Paginator::useBootstrapFive(); // <<< BARIS KRITIS


        // Definisikan semua Gates atau gerbang di dalam metode boot()

        // 1. GATE / gerbang UNTUK SUPER ADMIN
        // Hanya pengguna dengan peran 'super_admin' yang diizinkan
        // gerbang definisikan adalahSuperAdmin, jalankan fungsi berikut, lalu ambil detail user yang login
        Gate::define('isSuperAdmin', function ($user) {
            // untuk memeriksa apakah pengguna yang saat ini login memiliki peran (peran) sebagai super_admin. Jika peran pengguna tersebut adalah super_admin, kode akan mengembalikan nilai true.
            // jika detail user, column peran sama dengan 'super_admin' maka
            return $user->peran === 'super_admin';
        });

        // 2. GATE UNTUK ADMIN (Termasuk Super Admin)
        // Pengguna dengan peran 'admin' atau 'super_admin' yang diizinkan
        Gate::define('isAdmin', function ($user) {
            // tanda || berarti atau, jadi jika peran user adalah admin ATAU super_admin maka izinkan
            // jadi tanda || itu hanya butuh salah satu kondisi true untuk menghasilkan true
            return $user->peran === 'admin' || $user->peran === 'super_admin';
        });

        // 3. GATE UNTUK STAFF
        // Pengguna dengan peran 'staff' yang diizinkan
        Gate::define('isStaff', function ($user) {
            return $user->peran === 'staff';
        });
    }
}
