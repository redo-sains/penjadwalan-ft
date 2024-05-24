<?php

namespace Database\Seeders;

use App\Models\M_jurusan;
use App\Models\M_mata_kuliah;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class SeederMataKuliah extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $jurusanIds = M_jurusan::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            M_mata_kuliah::create([
                'nama' => $faker->sentence(3),
                'kode' => strtoupper($faker->unique()->bothify('MK###')),
                'semester' => $faker->numberBetween(1, 8),
                'jurusan_id' => $faker->randomElement($jurusanIds),
                'sks' => $faker->numberBetween(1, 4),
            ]);
        }
    }
    public function down()
    {
        // Hapus data  yang dimasukkan oleh seeder
        M_mata_kuliah::truncate();
    }
}
