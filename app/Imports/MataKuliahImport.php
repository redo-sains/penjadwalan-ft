<?php

namespace App\Imports;

use App\Models\M_mata_kuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MataKuliahImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        if($row['nama']!=""){
            return new M_mata_kuliah([
                "kode" => $row['kode'],
                "nama" => $row['nama'],
                "sks" => $row['sks'],
                "jumlah" => $row['jumlah_mahasiswa'],
                "semester" => $row['semester'],
                "jurusan_id" => $row['jurusan_id'],
            ]);
        }
    }
}
