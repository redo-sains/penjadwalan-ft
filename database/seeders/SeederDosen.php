<?php

namespace Database\Seeders;

use App\Models\M_dosen;
use App\Models\M_jurusan;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SeederDosen extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $jurusanIds = M_jurusan::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            M_dosen::create([
                'nama' => $faker->name,
                'kode' => strtoupper($faker->unique()->bothify('??###')),
                'jurusan_id' => $faker->randomElement($jurusanIds),
            ]);
        }
    }
    public function down()
    {
        // Hapus data  yang dimasukkan oleh seeder
        M_dosen::truncate();
    }
}
