<?php

namespace App\Http\Controllers;

use App\Models\M_dosen;
use App\Models\M_jurusan;
use App\Models\M_mata_kuliah;
use Illuminate\Http\Request;

class Controller_Mahasiswa extends Controller
{
    //
    public function show()
    {
        $title = 'Dashboard Mahasiswa';
        $dosens = M_dosen::paginate(100);
        $jurusans = M_jurusan::paginate(100);
        $matakuliahs = M_mata_kuliah::paginate(100);
        return view('mahasiswa.Dashboard.index', compact('title', 'dosens', 'jurusans', 'matakuliahs'));
    }
}
