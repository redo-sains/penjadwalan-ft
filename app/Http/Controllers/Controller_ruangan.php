<?php

namespace App\Http\Controllers;

use App\Imports\RuanganImport;
use App\Models\M_jurusan;
use App\Models\M_ruangan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Controller_ruangan extends Controller
{
    //
    public function show()
    {
        $title = 'Master Ruangan';
        $Ruangans = M_ruangan::paginate(8);
        $jurusan = M_jurusan::all();
        return view('admin.ruangan.index', compact('Ruangans', 'title', 'jurusan'));
    }
    public function create(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:ruangan',
            'kapasitas' => 'required|integer|min:1',
            'tipe_ruangan' => 'required|string|in:umum,online,khusus',
            'jurusan_id' => 'nullable|exists:jurusan,id', // Validasi jurusan_id jika ada
        ]);

        // Buat instansi baru dari M_ruangan
        $ruangan = new M_ruangan();
        $ruangan->nama = $validatedData['nama'];
        $ruangan->kode = $validatedData['kode'];
        $ruangan->kapasitas = $validatedData['kapasitas'];
        $ruangan->tipe_ruangan = $validatedData['tipe_ruangan'];

        // Set jurusan_id jika tipe_ruangan adalah khusus
        if ($validatedData['tipe_ruangan'] == 'khusus') {
            $ruangan->jurusan_id = $validatedData['jurusan_id'];
        } else {
            $ruangan->jurusan_id = null; // Atur ke null jika bukan khusus
        }

        $ruangan->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return redirect()->route('ruangan')->with('success', 'Data Ruangan ' . $request->nama . ' berhasil ditambahkan');
    }

    // controller
    public function edit($id)
    {
        $title = 'Master Ruangan';
        $ruangan = M_ruangan::findOrFail($id);
        $jurusan = M_jurusan::all();
        return view('admin.ruangan.edit', compact('title', 'ruangan', 'jurusan'));
    }
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:ruangan,kode,' . $id,
            'kapasitas' => 'required|integer|min:1',
            'tipe_ruangan' => 'required|string|in:umum,online,khusus',
            'jurusan_id' => 'nullable|exists:jurusan,id', // Validasi jurusan_id jika ada
        ]);

        // Cari ruangan berdasarkan ID
        $ruangan = M_ruangan::findOrFail($id);

        // Update data ruangan
        $ruangan->nama = $validatedData['nama'];
        $ruangan->kode = $validatedData['kode'];
        $ruangan->kapasitas = $validatedData['kapasitas'];
        $ruangan->tipe_ruangan = $validatedData['tipe_ruangan'];

        // Set jurusan_id jika tipe_ruangan adalah khusus
        if ($validatedData['tipe_ruangan'] == 'khusus') {
            $ruangan->jurusan_id = $validatedData['jurusan_id'];
        } else {
            $ruangan->jurusan_id = null; // Atur ke null jika bukan khusus
        }

        // Simpan perubahan
        $ruangan->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
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

    public function import(Request $request)
    {                        
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');		
 
		// import data
		Excel::import(new RuanganImport, $file);
 
		// alihkan halaman kembali
		return back()->with('success','Data Jurusan Berhasil Diimport!');
	
    }
}
