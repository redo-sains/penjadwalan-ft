<?php

namespace App\Http\Controllers;

use App\Models\M_dosen;
use App\Models\M_jurusan;
use App\Models\M_kelas;
use App\Models\M_mata_kuliah;
use Illuminate\Http\Request;

class Controller_kelas extends Controller
{
    public function show()
    {
        $title = 'Master Kelas';
        $kelases = M_kelas::with(['jurusan', 'mataKuliah', 'dosen'])->paginate(10);
        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        return view('admin.kelas.index', compact('kelases', 'title', 'jurusans', 'dosens', 'matkuls'));
    }
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'jurusan_id' => 'required|integer|exists:jurusan,id',
            'matkul_id' => 'required|integer|max:50',
            'dosen_id' => 'required|integer|max:50',
            'kapasitas' => 'required|integer|max:50',
            'kelas' => 'required|string|max:50',
        ]);
        M_kelas::create($validatedData);
        return redirect()->route('kelas')->with('success', 'Data kelas berhasil ditambahkan');
    }
    // controller
    public function edit($id)
    {
        $title = 'Master Kelas';
        $kelas = M_kelas::findOrFail($id);
        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        return view('admin.kelas.edit', compact('title', 'kelas', 'jurusans', 'matkuls', 'matkuls', 'dosens'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jurusan_id' => 'required|integer|exists:jurusan,id',
            'matkul_id' => 'required|integer|max:50',
            'dosen_id' => 'required|integer|max:50',
            'kapasitas' => 'required|integer|max:50',
            'kelas' => 'required|string|max:50',
        ]);
        $kelas = M_kelas::findOrFail($id);
        $kelas->update($validatedData);
        return redirect()->route('kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Temukan guru berdasarkan ID
        $kelas = M_kelas::findOrFail($id);
        $kelas->delete();
        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data kelas telah dihapus');
    }
}
