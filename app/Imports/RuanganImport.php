<?php

namespace App\Imports;

use App\Models\M_ruangan;
use Maatwebsite\Excel\Concerns\ToModel;

class RuanganImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new M_ruangan([
            "nama" => $row[1],
            "kode" => $row[2],
            "kapasitas" => $row[3],
            "tipe_ruangan" => $row[4],
        ]);
    }
}
