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
            'kode_guru' => 'required|string|max:50|unique:tb_guru',
        ]);
        // Simpan data guru baru ke dalam database
        $guru = new M_jurusan();
        $guru->nama = $request->nama;
        $guru->kode_guru = $request->kode_guru;
        $guru->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('guru')->with('success', 'Data guru ' . $request->nama . ' berhasil ditambahkan');
    }
    // controller
    public function edit($id)
    {
        $title = 'Master guru';
        $guru = M_jurusan::findOrFail($id);
        return view('admin.guru.edit', compact('title', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'kode_guru' => 'required|string|max:50',
        ]);
        $guru = M_jurusan::findOrFail($id);
        // Periksa apakah kode_guru yang baru unik jika diubah
        if ($request->kode_guru !== $guru->kode_guru) {
            $request->validate([
                'id_guru' => 'unique:tb_guru,id_guru,' . $id,
            ]);
        }

        $guru->nama = $request->nama;
        $guru->kode_guru = $request->kode_guru;
        $guru->save();

        return redirect()->route('guru')->with('success', 'Data guru berhasil diperbarui.');
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
