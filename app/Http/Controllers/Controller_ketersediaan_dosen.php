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
        $k_dosen = M_ketersediaan_dosen::findOrFail($id);
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $dosens = M_dosen::all();
        return view('admin.ketersediaan_dosen.edit', compact('title', 'k_dosen', 'days', 'dosens'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'dosen_id' => 'required|string|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);
        $ketersediaanDosen = M_ketersediaan_dosen::findOrFail($id);
        $ketersediaanDosen->update($validatedData);
        return redirect()->route('k_dosen')->with('success', 'Data ketersediaan dosens berhasil diperbarui.');
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
