<?php

namespace App\Imports;

use App\Models\M_ruangan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RuanganImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['nama'] != ""){
            return new M_ruangan([
                "nama" => $row['nama'],
                "lantai" => $row['lantai'],
                "kode" => $row['kode'],
                "kapasitas" => $row['kapasitas'],
                "tipe_ruangan" => $row['tipe_ruangan'],
            ]);
        }
    }
}
