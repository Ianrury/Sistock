<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DataObatFactory extends Factory
{
    protected $model = \App\Models\DataObat::class;

    public function definition()
    {
        return [
            'nama_obat' => $this->faker->word(),
            'jenis_obat' => $this->faker->randomElement(['Tablet', 'Kapsul', 'Sirup']),
            'tanggal_kadaluarsa' => $this->faker->dateTimeBetween('+1 years', '+3 years'),
            'bentuk' => $this->faker->randomElement(['Padat', 'Cair']),
            'isi_kemasan' => $this->faker->numberBetween(10, 100),
            'tanggal_masuk' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'stock_obat' => $this->faker->numberBetween(1, 100),
            'satuan' => $this->faker->randomElement(['box', 'botol', 'strip']),
            'dosis' => $this->faker->randomElement(['1x sehari', '2x sehari']),
            'superadmin_id' => 2, // sesuaikan dengan superadmin yang valid
        ];
    }
}
