<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// agar bisa berinteraksi dengan table kantor
use App\Models\Kantor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kantor>
 */
class KantorFactory extends Factory
{
    // definisikan model yang akan digunakan oleh factory ini
    protected $model = Kantor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Contoh data yang akan dihasilkan secara acak
            // menggunakan lirary faker untuk menghasilkan data palsu
            'nama' => $this->faker->company() . ' Cabang ' . $this->faker->city(),
            'alamat' => $this->faker->address(),
            'tipe' => 'cabang',
        ];
    }
}
