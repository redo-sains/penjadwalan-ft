<?php

namespace App\Http\Controllers;

use App\Models\M_jurusan;
use App\Models\M_mata_kuliah;
use Illuminate\Http\Request;

class Controller_mata_kuliah extends Controller
{
    //
    public function show()
    {
        $title = 'Master Mata Kuliah';
        $matakuls = M_mata_kuliah::paginate(5);
        $jurusans = M_jurusan::all();
        return view('admin.mata_kuliah.index', compact('matakuls', 'title', 'jurusans'));
    }
    public function create(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_kuliah',
            'semester' => 'required|string|max:50',
            'sks' => 'required|string|max:50',
            'jurusan_id' => 'required|integer|exists:jurusan,id',
        ]);
        $dosen = new M_mata_kuliah();
        $dosen->nama = $request->nama;
        $dosen->kode = $request->kode;
        $dosen->semester = $request->semester;
        $dosen->sks = $request->sks;
        $dosen->jurusan_id = $request->jurusan_id;
        $dosen->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('matkul')->with('success', 'Data mata kuliah ' . $request->nama . ' berhasil ditambahkan');
    }
    // controller
    public function edit($id)
    {
        $title = 'Master Mata Kuliah';
        $matkul = M_mata_kuliah::findOrFail($id);
        $jurusans = M_jurusan::all();
        return view('admin.mata_kuliah.edit', compact('title', 'matkul', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
            'semester' => 'required|string|max:50',
            'sks' => 'required|string|max:50',
            'jurusan_id' => 'required|integer|exists:jurusan,id',
        ]);

        $matkul = M_mata_kuliah::findOrFail($id);
        if ($request->kode !== $matkul->kode) {
            $request->validate([
                'id' => 'unique:mata_kuliah,id,' . $id,
            ]);
        }
        $matkul->nama = $request->nama;
        $matkul->kode = $request->kode;
        $matkul->semester = $request->semester;
        $matkul->sks = $request->sks;
        $matkul->jurusan_id = $request->jurusan_id;
        $matkul->save();
        return redirect()->route('matkul')->with('success', 'Data mata kuliah berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Temukan guru berdasarkan ID
        $matkul = M_mata_kuliah::findOrFail($id);
        // Hapus guru
        $matkul->delete();
        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data mata kuliah ' . $matkul->nama . ' berhasil dihapus');
    }
}
