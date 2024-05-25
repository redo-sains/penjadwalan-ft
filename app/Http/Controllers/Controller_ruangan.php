<?php

namespace App\Http\Controllers;

use App\Models\M_ruangan;
use Illuminate\Http\Request;

class Controller_ruangan extends Controller
{
    //
    public function show()
    {
        $title = 'Master Ruangan';
        $Ruangans = M_ruangan::paginate(5);
        return view('admin.ruangan.index', compact('Ruangans', 'title'));
    }
    public function create(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:ruangan',
            'semester' => 'required|string|max:50',
            'sks' => 'required|string|max:50',
            'jurusan_id' => 'required|integer|exists:jurusan,id',
        ]);
        $dosen = new M_ruangan();
        $dosen->nama = $request->nama;
        $dosen->kode = $request->kode;
        $dosen->semester = $request->semester;
        $dosen->sks = $request->sks;
        $dosen->jurusan_id = $request->jurusan_id;
        $dosen->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('matkul')->with('success', 'Data Ruangan ' . $request->nama . ' berhasil ditambahkan');
    }
    // controller
    public function edit($id)
    {
        $title = 'Master Ruangan';
        $matkul = M_ruangan::findOrFail($id);
        return view('admin.ruangan.edit', compact('title', 'matkul'));
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

        $matkul = M_ruangan::findOrFail($id);
        if ($request->kode !== $matkul->kode) {
            $request->validate([
                'id' => 'unique:ruangan,id,' . $id,
            ]);
        }
        $matkul->nama = $request->nama;
        $matkul->kode = $request->kode;
        $matkul->semester = $request->semester;
        $matkul->sks = $request->sks;
        $matkul->jurusan_id = $request->jurusan_id;
        $matkul->save();
        return redirect()->route('matkul')->with('success', 'Data Ruangan berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Temukan guru berdasarkan ID
        $matkul = M_ruangan::findOrFail($id);
        // Hapus guru
        $matkul->delete();
        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data Ruangan ' . $matkul->nama . ' berhasil dihapus');
    }
}
