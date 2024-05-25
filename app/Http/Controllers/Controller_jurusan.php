<?php

namespace App\Http\Controllers;

use App\Models\M_jurusan;
use Illuminate\Http\Request;

class Controller_jurusan extends Controller
{
    //
    public function show()
    {
        $title = 'Master Jurusan';
        $jurusans = M_jurusan::paginate(5);
        return view('admin.jurusan.index', compact('jurusans', 'title'));
    }
    public function tambah()
    {
        $title = 'Master guru';
        return view('admin.guru.tambah', compact('title'));
    }
    public function create(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:jurusan',
        ]);
        // dd($validatedData);
        // Simpan data guru baru ke dalam database
        $jurusan = new M_jurusan();
        $jurusan->nama = $request->nama;
        $jurusan->kode = $request->kode;
        $jurusan->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('jurusan')->with('success', 'Data jurusan ' . $request->nama . ' berhasil ditambahkan');
    }
    // controller
    public function edit($id)
    {
        $title = 'Master Jurusan';
        $jurusan = M_jurusan::findOrFail($id);
        return view('admin.jurusan.edit', compact('title', 'jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'kode' => 'required|string|max:50',
        ]);
        $jurusan = M_jurusan::findOrFail($id);
        // Periksa apakah kode_guru yang baru unik jika diubah
        if ($request->kode !== $jurusan->kode) {
            $request->validate([
                'id' => 'unique:jurusan,id,' . $id,
            ]);
        }

        $jurusan->nama = $request->nama;
        $jurusan->kode = $request->kode;
        $jurusan->save();

        return redirect()->route('jurusan')->with('success', 'Data jurusan berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Temukan guru berdasarkan ID
        $guru = M_jurusan::findOrFail($id);
        // Hapus guru
        $guru->delete();

        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data guru ' . $guru->nama . ' berhasil dihapus');
    }
}
