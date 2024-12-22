<?php

namespace App\Http\Controllers;

use App\Exports\Export_Template_Matkul;
use App\Imports\MataKuliahImport;
use App\Models\M_jurusan;
use App\Models\M_kelas;
use App\Models\M_mata_kuliah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Controller_mata_kuliah extends Controller
{
    //
    public function show()
    {
        $title = 'Master Mata Kuliah';
        $matakuls = M_mata_kuliah::paginate(75);
        $jurusans = M_jurusan::all();
        return view('admin.mata_kuliah.index', compact('matakuls', 'title', 'jurusans'));
    }

    // public function showAll()
    // {
    //     $title = 'Master Mata Kuliah';
    //     $matakuls = M_mata_kuliah::paginate(75);
    //     $jurusans = M_jurusan::all();
    //     return view('admin.mata_kuliah.index', compact('matakuls', 'title', 'jurusans'));
    // }

    public function create(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_kuliah',
            'semester' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'sks' => 'required|string|max:50',
            'jurusan_id' => 'required|integer|exists:jurusan,id',
            'jumlah_kelas' => 'required|integer|min:1',
        ]);

        $kelas = ['A','B','C','D','E','F'];

        if($request->jumlah_kelas == 1){
            $dosen = new M_mata_kuliah();
            $dosen->nama = $request->nama;
            $dosen->kode = $request->kode;
            $dosen->jumlah = $request->jumlah;
            $dosen->semester = $request->semester;
            $dosen->sks = $request->sks;
            $dosen->jurusan_id = $request->jurusan_id;
            $dosen->save();
        }else{
            for($i = 0; $i < $request->jumlah_kelas; $i++) {
                $dosen = new M_mata_kuliah();
                $dosen->nama = $request->nama . ' ('. $kelas[$i] . ')';
                $dosen->kode = $request->kode;
                $dosen->jumlah = $request->jumlah;
                $dosen->semester = $request->semester;
                $dosen->sks = $request->sks;
                $dosen->jurusan_id = $request->jurusan_id;
                $dosen->save();
            }
        }

        

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return back()->with('success', 'Data mata kuliah ' . $request->nama . ' berhasil ditambahkan');
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
            'jumlah' => 'required|integer|min:1',
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
        $matkul->jumlah = $request->jumlah;
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

    public function import(Request $request)
    {                        
        // validasi
		$this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
        
        try{
            $test = Excel::import(new MataKuliahImport, $file);
            // dd($test);
             
            return back()->with('success','Data Jurusan Berhasil Diimport!');
        }catch(\Exception $ex){
            return back()->with('error','Data Jurusan Berhasil Diimport!');
        } 
	
    }

    public function show_class($id)
    {
        $title = 'Kelas Mata Kuliah';
        $kelas = M_kelas::where('matkul_id', $id)->paginate(25);
        $alphabet = range('A', 'Z');    
        
        return view('admin.mata_kuliah.kelas', compact( 'title', 'kelas','id', 'alphabet'));
    }

    public function show_class_all()
    {
        $title = 'Kelas Mata Kuliah';
        $data = M_kelas::paginate(75);
        $alphabet = range('A', 'Z');    

        $kelas = [];
        foreach ($data as $key => $value) {
            // -> as it return std object
            $kelas[$value->matkul_id][] = $value;
        }

        // dd($kelas);
        
        return view('admin.mata_kuliah.kelas_all', compact( 'title', 'kelas', 'alphabet', 'data'));
    }

    public function add_class(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'matkul_id' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);
        
        $dosen = M_kelas::create([
            "matkul_id" => $validatedData['matkul_id'],
            "jumlah" => $validatedData['jumlah'],
        ]);                           

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return back()->with('success', 'Kelas baru berhasil ditambahkan');
    }

    public function edit_class(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);
        
        $matkul = M_kelas::findOrFail($validatedData['id']);                     
        
        $matkul->update([
            "jumlah" => $validatedData['jumlah'],
        ]);        

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return back()->with('success', 'Kelas baru berhasil ditambahkan');
    }

    public function remove_class(Request $request ,$id)
    {
        // dd();

        if(M_kelas::where('matkul_id',$request->id_matkul)->count() < 2){
            return redirect()->back()->with('error', 'Kelas gagal dihapus atau kelas harus lebih dari satu');    
        }

        // Temukan guru berdasarkan ID
        $matkul = M_kelas::findOrFail($id);
        

        // Hapus guru
        $matkul->delete();

        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Kelas berhasil dihapus');
    }

    public function exportTemplate()
    {
        
        return Excel::download(new Export_Template_Matkul, 'template-matkul.xlsx');
    }
}
