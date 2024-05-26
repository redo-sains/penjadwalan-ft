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
            'nama' => 'string|max:255',
            'kode' => 'string|max:50|unique:ruangan',
            'kapasitas' => 'string|max:50',

        ]);
        $dosen = new M_ruangan();
        $dosen->nama = $request->nama;
        $dosen->kode = $request->kode;
        $dosen->kapasitas = $request->kapasitas;
        $dosen->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('ruangan')->with('success', 'Data Ruangan ' . $request->nama . ' berhasil ditambahkan');
    }
    // controller
    public function edit($id)
    {
        $title = 'Master Ruangan';
        $ruangan = M_ruangan::findOrFail($id);
        return view('admin.ruangan.edit', compact('title', 'ruangan'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'string|max:255',
            'kode' => 'string|max:50',
            'kapasitas' => 'string|max:50',
        ]);

        $ruangan = M_ruangan::findOrFail($id);
        if ($request->kode !== $ruangan->kode) {
            $request->validate([
                'id' => 'unique:ruangan,id,' . $id,
            ]);
        }
        $ruangan->nama = $request->nama;
        $ruangan->kode = $request->kode;
        $ruangan->kapasitas = $request->kapasitas;
        $ruangan->save();
        return redirect()->route('ruangan')->with('success', 'Data Ruangan berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Temukan guru berdasarkan ID
        $ruangan = M_ruangan::findOrFail($id);
        // Hapus guru
        $ruangan->delete();
        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data Ruangan ' . $ruangan->nama . ' berhasil dihapus');
    }
}
