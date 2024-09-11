<?php

namespace App\Http\Controllers;

use App\Imports\DosenImport;
use App\Models\M_dosen;
use App\Models\M_jurusan;
use App\Models\M_population_dosen;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Controller_dosen extends Controller
{
    //
    public function show()
    {
        $title = 'Master dosen';
        $dosens = M_dosen::paginate(5);
        $jurusans = M_jurusan::all();
        return view('admin.dosen.index', compact('dosens', 'title', 'jurusans'));
    }
    public function create(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:dosen',
            'jurusan_id' => 'required|integer|exists:jurusan,id',
            'tersedia' => 'required|boolean',
        ]);
        $dosen = new M_dosen();
        $dosen->nama = $request->nama;
        $dosen->kode = $request->kode;
        $dosen->tersedia = $request->tersedia;
        $dosen->jurusan_id = $request->jurusan_id;
        $dosen->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('dosen')->with('success', 'Data dosen ' . $request->nama . ' berhasil ditambahkan');
    }
    // controller
    public function edit($id)
    {
        $title = 'Master dosen';
        $dosen = M_dosen::findOrFail($id);
        $jurusans = M_jurusan::all();
        return view('admin.dosen.edit', compact('title', 'dosen', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
            'jurusan_id' => 'required|integer|exists:jurusan,id',
            'tersedia' => 'required|boolean',
        ]);
        $dosen = M_dosen::findOrFail($id);        
        // Periksa apakah kode_guru yang baru unik jika diubah
        if ($request->kode !== $dosen->kode) {
            $request->validate([
                'id' => 'unique:dosen,id,' . $id,
            ]);
        }

        
        if($request->tersedia == false){
            $exist = M_population_dosen::where('dosen_id',$id)->exists();

            if($exist){
                return back()->with('error', 'Data Dosen Masih Di Pakai Di Pengampu.');
            }            

        }

        $dosen->nama = $request->nama;
        $dosen->kode = $request->kode;
        $dosen->tersedia = $request->tersedia;
        $dosen->jurusan_id = $request->jurusan_id;
        $dosen->save();

        return redirect()->route('dosen')->with('success', 'Data dosen berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Temukan guru berdasarkan ID
        $dosen = M_dosen::findOrFail($id);
        // Hapus guru
        $dosen->delete();
        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data dosen ' . $dosen->nama . ' berhasil dihapus');
    }

    public function import(Request $request)
    {
        
                
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');		
 
		// import data
		Excel::import(new DosenImport, $file);
 
		// alihkan halaman kembali
		return back()->with('success','Data Dosen Berhasil Diimport!');
	
    }
}
