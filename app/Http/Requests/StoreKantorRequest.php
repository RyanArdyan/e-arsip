<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKantorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Mendapatkan objek pengguna yang sedang login
        $user = $this->user();

        // Memeriksa peran pengguna
        // Ekspresi $user && $user->peran === 'super_admin'; akan menghasilkan nilai true (diizinkan) hanya jika kedua kondisi tersebut bernilai true:
        // jika ada detail user
        // jika detail user, column peran adalah 'super_admin'
        return $user && $user->peran === 'super_admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // wajib, maksimal 255 karakter, unik di table kantor pada column nama
            'nama' => ['required', 'string', 'max:255', 'unique:kantor,nama'],
            'alamat' => ['required', 'string'],
            'tipe' => ['required', 'in:pusat,cabang'], // Hanya menerima nilai dari ENUM
        ];
    }

    // Pesan kustom untuk validasi
    public function messages(): array
    {
        return [
            // terjemahan untuk nama.unique
            'nama.unique' => 'Nama kantor ini sudah terdaftar. Gunakan nama lain.',
            'tipe.in' => 'Tipe kantor harus salah satu dari "pusat" atau "cabang".',
        ];
    }
}
