<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    // Di dalam class UserFactory

    public function admin(): static
    {
        // Fungsi utama dari method admin() tersebut adalah untuk memungkinkan Anda membuat data User dengan kondisi atau status tertentu (dalam hal ini memiliki peran sebagai "admin") secara cepat tanpa harus mendefinisikannya secara manual setiap kali membuat data.
        return $this->state(fn (array $attributes) => [
            // 'peran' => 'admin' Inilah inti perubahannya. Baris ini memerintahkan Laravel: "Apa pun nilai default untuk kolom 'peran', ganti menjadi 'admin' ketika method ini dipanggil."
            'peran' => 'admin',
        ]);
    }

    public function staff(): static
    {
        return $this->state(fn (array $attributes) => [
            'peran' => 'staff',
        ]);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Menghasilkan angka acak antara 1 sampai 16
            'kantor_id' => fake()->numberBetween(1, 16),
            // nama palsu
            'name' => fake()->name(),
            // email unik palsu
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            // Pilihan enum sesuai permintaan
            'peran' => fake()->randomElement(['super_admin', 'admin', 'staff']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
