<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataObat;

class DataObatSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan cek foreign key agar truncate aman
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DataObat::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Generate 20 data menggunakan factory
        DataObat::factory()->count(20)->create();
    }
}
