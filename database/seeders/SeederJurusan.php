<?php

namespace Database\Seeders;

use App\Models\M_jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SeederJurusan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            M_jurusan::create([
                'nama' => $faker->unique()->word . ' ' . $faker->unique()->word,
                'kode' => strtoupper($faker->unique()->bothify('??###')),
            ]);
        }
    }
    public function down()
    {
        // Hapus data  yang dimasukkan oleh seeder
        M_jurusan::truncate();
    }
}
