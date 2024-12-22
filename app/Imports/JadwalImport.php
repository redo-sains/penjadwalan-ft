<?php

namespace App\Imports;

use App\Models\M_Populations;
use App\Models\M_population_dosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JadwalImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // dd($rows);

        foreach ($rows as $row) 
        {
            if($row['jurusan_id'] != "" && isset($row['jurusan_id'])){
                $population = M_Populations::create([
                    "jurusan_id" => $row['jurusan_id'],
                    "matkul_id" => $row['matkul_id'],                                
                    "kurikulum_id" => $row['kurikulum_id'],                                                      
                ]);
    
                $listDosen = explode(",",str_replace(' ', '', $row['list_dosen']));
    
                foreach ($listDosen as $dosen_id) {                
                    M_population_dosen::create([
                        'population_id' => $population->id,
                        'dosen_id' => $dosen_id,
                    ]);
                }    
            }
            
        }
    }
    
}
