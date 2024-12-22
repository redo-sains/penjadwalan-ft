<?php

namespace App\Imports;

use App\Models\M_dosen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
        if($row['nama'] != ""){

            $gender = strtolower($row['jenis_kelamin']) == 'l' ? 'male' : 'female';            

            return new M_dosen([
                "nama" => $row['nama'],
                "umur" => $row['umur'],
                "gender" => $gender,
                "kode" => $row['kode'],
                "jurusan_id" => $row['id_jurusan'],
                "tersedia" =>$row['tersedia'],
            ]);
        };
    }
}
