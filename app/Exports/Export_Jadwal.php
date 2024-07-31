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

class Export_Jadwal implements FromView
{
    public function view(): View
    {
        $populations = M_Populations::with(['jurusan', 'mataKuliah', 'dosen', 'ruangan'])->get(); // Menggunakan get() daripada paginate(10)
        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        $ruangans = M_ruangan::all();
        $kurikulums = M_kurikulum::all();
        return view('admin.generate.exportExcel', compact('jurusans', 'populations', 'matkuls', 'dosens', 'ruangans', 'kurikulums'));
    }
}

