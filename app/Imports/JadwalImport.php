<?php

namespace App\Imports;

use App\Models\M_Populations;
use App\Models\M_population_dosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class JadwalImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $population = M_Populations::create([
                "jurusan_id" => $row[2],
                "matkul_id" => $row[3],                                
                "kurikulum_id" => $row[4],                                                      
            ]);

            $listDosen = explode(",",str_replace(' ', '', $row[1]));

            foreach ($listDosen as $dosen_id) {                
                M_population_dosen::create([
                    'population_id' => $population->id,
                    'dosen_id' => $dosen_id,
                ]);
            }

        }
    }
    
}
