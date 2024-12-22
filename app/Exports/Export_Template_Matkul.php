<?php

namespace App\Exports;

use App\Models\M_dosen;
use App\Models\M_jurusan;
use App\Models\M_kurikulum;
use App\Models\M_mata_kuliah;
use App\Models\M_Populations;
use App\Models\M_ruangan;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class Export_Template_Matkul implements FromView
{
    public function view(): View
    {        
        return view('admin.template.matkulExcel');
    }
}

