<?php

namespace Database\Seeders;

use App\Models\M_user;
use App\Models\M_users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SeederUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        {
            M_users::create([
                'username' => 'admin',
                'password' => Hash::make('123'), // Menggunakan Hash::make() untuk menghash kata sandi
                'role' => 'admin',
                'created_at' => now(),
                // 'updated_at' => now(),
            ]);
        }
    }
    public function down()
    {
        // Hapus data  yang dimasukkan oleh seeder
        M_users::truncate();
    }
}
