<?php

namespace App\Imports;

use App\Models\M_jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JurusanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            if($row['nama'] != ""){
                return new M_jurusan([
                    "nama" => $row['nama'],
                    "kode" => $row['kode'],            
                ]);
        }
    }
}
