<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// import database
use Illuminate\Support\Facades\DB;
// untuk melakukan hash pada
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // panggil database dari table user lalu masukkan
        DB::table('users')->insert([
            'kantor_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
            'peran' => 'admin'
        ]);
    }
}
