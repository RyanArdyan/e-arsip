<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// agar bisa berinteraksi dengan database
use App\Models\User;
// agar bisa berintekraksi dengan data user yang sedang login
use Illuminate\Support\Facades\Auth;
// untuk meng-hash password
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function edit_profile()
    {
        // cari pengguna berdasarkan user_id yang sedang login
        $detail_user = User::find(auth()->user()->user_id);
        // kembali ke tampilan berikut lalu kirimkan data
        return view('shared.profile.index', [
            // kirimkan key name berisi detail user yg login, column name dan email
            'name' => $detail_user->name,
            'email' => $detail_user->email,
            'tanda_tangan' => $detail_user->tanda_tangan,
        ]);
    }

        // $request berisi data yang dikirimkan dari form
        public function update_profile(Request $request)
        {
            // // validasi data yang dikirimkan
            // $validatedData = $request->validate([
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|string|email|max:255|unique:users,email,' . auth()->user()->user_id . ',user_id',
            //     'password_lama' => 'nullable|string|min:8',
            //     'password_baru' => 'nullable|string|min:8',
            // ]);

            // // cari pengguna berdasarkan user_id yang sedang login
            // $user = User::find(auth()->user()->user_id);

            // // perbarui nama dan email
            // $user->name = $validatedData['name'];
            // $user->email = $validatedData['email'];

            // // jika password lama diisi, periksa kecocokan dan perbarui password
            // if (!empty($validatedData['password_lama'])) {
            //     if (password_verify($validatedData['password_lama'], $user->password)) {
            //         // value column password di-hash sebelum disimpan
            //         $user->password = Hash::make($validatedData['password_baru']);
            //     } else {
            //         return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.'])->withInput();
            //     }
            // }

            // // simpan perubahan
            // $user->save();

            // // alihkan kembali dengan pesan sukses
            // return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');



            // berisi panggil detail user
            $user = Auth::user();

            // 1. Definisikan Aturan Dasar yang berupa array
            $rules = [
                // input name harus wajib diisi, bertipe string, maksimal 255 karakter
                'name' => ['required', 'string', 'max:255'],
                // Rule::unique('users')->ignore($user->user_id, 'user_id')
                // untuk mengabaikan email user saat ini saat validasi keunikan
                // Rule::unique('users', 'email')->ignore($user->user_id, 'user_id') berarti harus unik tapi mengabaikan record dengan user_id yang login
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
                'tanda_tangan' => ['nullable', 'image', 'mimes:png', 'max:2048'], // Hanya PNG, maks 2MB
            ];

            // 2. Logika Validasi Password Bersyarat
            // jika ada password lama atau baru yang diisi
            if ($request->filled('password_lama') || $request->filled('password_baru')) {
                // Jika salah satu (lama/baru) diisi, maka keduanya wajib diisi
                $rules['password_lama'] = ['required'];
                $rules['password_baru'] = ['required', 'min:8'];
            }

            // 3. Jalankan Validasi
            // beriisi panggil request, lalu jalankan method validate dengan mengirimkan rules
            $validatedData = $request->validate($rules);

            // --- 4. Proses Update Data ---

            // Data yang akan diupdate secara default (Nama & Email)
            $dataToUpdate = [
                // kunci name akan mengambil data dari value pada validatedData dengan key name karena sudah lolos validasi
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ];

            // 5. Penanganan Perubahan Password
            // jika password lama dan baru diisi maka
            if ($request->filled('password_lama') && $request->filled('password_baru')) {
                // Cek apakah password lama yang dimasukkan benar
                // jika password lama tidak sesuai dengan password di database
                if (!Hash::check($request->password_lama, $user->password)) {
                    // kembali ke halaman sebelumnya dengan pesan error yang dikirimkan menggunakan key berikut
                    return back()->withErrors(['password_lama' => 'Password Lama yang Anda masukkan salah.'])->withInput();
                }

                // Jika benar, update password dan lakukan hashing
                $dataToUpdate['password'] = Hash::make($request->password_baru);
            }

            // 6. Penanganan Upload Tanda Tangan
            // jika ada file tanda_tangan yang diupload
            if ($request->hasFile('tanda_tangan')) {
                // Hapus file TTD lama jika ada
                $oldPath = $user->tanda_tangan;
                // jika ada oldPath dan file tanda tangan dengan nama tersebut ada di storage maka hapus file tersebut
                if ($oldPath && Storage::disk('public')->exists('tanda_tangan/' . $oldPath)) {
                    // hapus storage/public/tanda_tangan/ diikuti nama file lama
                    Storage::disk('public')->delete('tanda_tangan/' . $oldPath);
                }

                // Simpan file baru
                // Nama file akan unik (timestamp/hash). 'tanda_tangan' adalah sub-folder
                $path = $request->file('tanda_tangan')->store('tanda_tangan', 'public');

                // Simpan hanya nama filenya ke database
                $dataToUpdate['tanda_tangan'] = basename($path);
            }

            // 7. Eksekusi Update ke Database
            $user->update($dataToUpdate);

            // kembali alihkan ke rute profile.edit dengan pesan sukses
            return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
        }
}
