<?php

namespace App\Http\Controllers;

use App\Models\M_dosen;
use App\Models\M_jurusan;
use App\Models\M_kurikulum;
use App\Models\M_mata_kuliah;
use App\Models\M_Populations;
use App\Models\M_ruangan;
use Illuminate\Http\Request;

class Controller_kurikulum extends Controller
{
    //
    public function show()
    {
        $kurikulums = M_kurikulum::paginate(8);
        $title = "Halaman kurikulum";
        return view('admin.kurikulum.index', compact('kurikulums', 'title'));
    }
    public function create(Request $request)
    {
        $dataValidate =    $request->validate([
            'tahun_mulai' => 'required',
            'tahun_selesai' => 'required',
        ]);
        M_kurikulum::create($dataValidate);
        return redirect()->route('kurikulum')->with('success', 'Kurikulum tahun' . $request->tahun_mulai . '/' . $request->tahun_mulai . '');
    }
    public function edit($id)
    {
        $title = 'Halaman edit kurikulum';
        $kurikulum = M_kurikulum::findOrFail($id);
        return view('admin.kurikulum.edit', compact('title', 'kurikulum'));
    }
    public function update(Request $request, $id)
    {
        $kurikulum = M_kurikulum::findOrFail($id);
        $validateData = $request->validate([
            'tahun_mulai' => 'required',
            'tahun_selesai' => 'required'
        ]);
        $kurikulum->update($validateData);
        return redirect()->route('kurikulum')->with('success', 'Berhasil melakukan perubahan data');
    }
    public function delete($id)
    {
        $kurikulum = M_kurikulum::findOrFail($id);
        $kurikulum->delete();
        return redirect()->route('kurikulum')->with('success', 'Tahun kurikulum telah dihapus');
    }
    public function select_periode(Request $request)
    {
        $validatedData = $request->validate([
            'kurikulum' => 'required'
        ]);
        $kurikulums = M_kurikulum::all();
        $id = $validatedData['kurikulum'];
        $populations = M_Populations::where('kurikulum_id', $id)->paginate(8);
        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        $ruangans = M_ruangan::all();
        $kurikulums = M_kurikulum::all();
        $title = "Halaman kurikulum";
        return view('admin.populations.index', compact('populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'kurikulums'));
    }
}
