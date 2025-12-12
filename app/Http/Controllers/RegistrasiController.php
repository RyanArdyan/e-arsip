<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// agar bisa berinteraksi dengan table users
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    public function index()
    {
        // kembalikkan ke tampilan auth.registrasi
        return view('auth.registrasi');
    }

    public function store(Request $request)
    {
        // Validasi input dari form registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'kantor_id' => 'required|exists:kantor,kantor_id',
        ]);

        // Hash password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);
        
        // Set peran default sebagai staff
        $validated['peran'] = 'staff';

        // Buat user baru
        User::create($validated);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login.index')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
