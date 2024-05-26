<?php

namespace App\Http\Controllers;

use App\Models\M_dosen;
use App\Models\M_jadwal;
use App\Models\M_jurusan;
use App\Models\M_ketersediaan_dosen;
use Illuminate\Http\Request;

class Controller_ketersediaan_dosen extends Controller
{
    //
    public function show()
    {
        $title = 'Master ketersediaan dosen';
        $ketersediaanDosens = M_ketersediaan_dosen::paginate(5);
        $dosens = M_dosen::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return view('admin.ketersediaan_dosen.index', compact('ketersediaanDosens', 'title', 'dosens', 'days'));
    }
    public function create(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'dosen_id' => 'required|string|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);
        // Simpan data ke database
        M_ketersediaan_dosen::create($validatedData);
        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('k_dosen')->with('success', 'Data ketersediaan dosen ' . $request->nama . ' berhasil ditambahkan');
    }
    // controller
    public function edit($id)
    {
        $title = 'Master dosen';
        $ketersediaanDosens = M_ketersediaan_dosen::findOrFail($id);
        $jurusans = M_jurusan::all();
        return view('admin.ketersediaanDosens.edit', compact('title', 'ketersediaanDosens', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
            'jurusan_id' => 'required|integer|exists:jurusan,id',
        ]);
        $ketersediaanDosen = M_ketersediaan_dosen::findOrFail($id);
        // Periksa apakah kode_guru yang baru unik jika diubah
        if ($request->kode !== $ketersediaanDosen->kode) {
            $request->validate([
                'id' => 'unique:ketersediaan_dosen,id,' . $id,
            ]);
        }

        $ketersediaanDosen->nama = $request->nama;
        $ketersediaanDosen->kode = $request->kode;
        $ketersediaanDosen->jurusan_id = $request->jurusan_id;
        $ketersediaanDosen->save();

        return redirect()->route('dosen')->with('success', 'Data dosen berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Temukan guru berdasarkan ID
        $dosen = M_ketersediaan_dosen::findOrFail($id);
        // Hapus guru
        $dosen->delete();
        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data dosen ' . $dosen->nama . ' berhasil dihapus');
    }
}
