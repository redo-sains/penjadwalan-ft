<?php

namespace App\Imports;

use App\Models\M_mata_kuliah;
use Maatwebsite\Excel\Concerns\ToModel;

class MataKuliahImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new M_mata_kuliah([
            "kode" => $row[1],
            "nama" => $row[2],
            "sks" => $row[3],
            "semester" => $row[4],
            "jurusan_id" => $row[5],
        ]);
    }
}
