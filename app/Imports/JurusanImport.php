<?php

namespace App\Imports;

use App\Models\M_jurusan;
use Maatwebsite\Excel\Concerns\ToModel;

class JurusanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new M_jurusan([
            "nama" => $row[1],
            "kode" => $row[2],            
        ]);
    }
}
