<?php

namespace App\Imports;

use App\Models\M_dosen;
use Maatwebsite\Excel\Concerns\ToModel;

class DosenImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new M_dosen([
            "nama" => $row[1],
            "kode" => $row[2],
            "jurusan_id" => $row[3],
            "tersedia" =>$row[4],
        ]);
    }
}
