<?php

namespace App\Http\Controllers;

use App\Exports\Export_Jadwal;
use App\Exports\Export_Template_Pengampu;
// use App\Exports\Export_Template;
use App\Imports\JadwalImport;
use App\Models\M_dosen;
use App\Models\M_jurusan;
use App\Models\M_kelas;
use App\Models\M_kurikulum;
use App\Models\M_mata_kuliah;
use App\Models\M_pengaturan_algoritma;
use App\Models\M_population_dosen;
use App\Models\M_Populations;
use App\Models\M_ruangan;
use App\Models\M_slot_waktu;
use App\Models\M_users;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Controller_populations extends Controller
{
    //
    public function show(Request $request)
    {
        $last_id = M_kurikulum::all()->last()->id;   
        if (isset($request->kurikulum_id)) {
            $validatedData = $request->validate([
                'kurikulum_id' => 'required'
            ]);
            $id = $request->kurikulum_id;

            $last = M_kurikulum::all()->last()->id;

            $kurikulums = M_kurikulum::all()->reverse()->values();

            $populations = M_Populations::where('kurikulum_id', $id);

            // dd()
            $jurusan_id = $request->jurusan_filter;
            if(isset($request->jurusan_filter) && $request->jurusan_filter != "" ){
                $populations = $populations->where('jurusan_id', $request->jurusan_filter);
            }

            $hari_id = $request->hari_filter;

            if(isset($request->hari_filter) && $request->hari_filter != "" ){
                $populations = $populations->where('hari', $request->hari_filter);
            }

            $populations = $populations->paginate(50);

            $jurusans = M_jurusan::all();
            $dosens = M_dosen::where(["tersedia" => 1])->get();
            $matkuls = M_mata_kuliah::all();
            $ruangans = M_ruangan::all();
            // $kurikulums = M_kurikulum::all();
            $title = "Halaman Populasi";
            $alphabet = range('A', 'Z');  
            foreach ($populations as $key => $value) {
                // -> as it return std object
                $matkul_kelas = M_kelas::where('matkul_id',$value->kelas->matkul_id)->get();

                $index_search = -1;

                if(count($matkul_kelas) > 1){
                    // $index_search = array_search($value->kelas, $matkul_kelas);
                    foreach($matkul_kelas as $index_kelas => $matkul_kelas_val){       
                        // dd($matkul_kelas_val->id , $value->kelas->id);
                        if($matkul_kelas_val->id === $value->kelas->id){
                            $index_search = $index_kelas;
                            break;
                        }
                    }
                    
                    $kelas_group = count($matkul_kelas) > 1 ? " *) (".$alphabet[$index_search].")" : '';

                    $value->nama = $value->kelas->mataKuliah->nama . $kelas_group;
                    
                    $populations[$key] = $value;
                }else{
                    $value->nama = $value->kelas->mataKuliah->nama;
                    $populations[$key] = $value;
                }                
            }

            return view('admin.populations.index', compact("hari_id" ,"jurusan_id",'last_id','populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'kurikulums', 'id'));
        }
        
        $id = M_kurikulum::all()->last()->id;        

        $route_name = $request->route()->getName();
        

        return redirect()->route($route_name, ["kurikulum_id" => $last_id]);     
        
    }

    public function pengampu(Request $request)
    {
        $last_id = M_kurikulum::all()->last()->id;    
        $alphabet = range('A', 'Z');    
        if (isset($request->kurikulum_id)) {
            $validatedData = $request->validate([
                'kurikulum_id' => 'required'
            ]);
            $id = $request->kurikulum_id;
            $last = M_kurikulum::all()->last()->id;

            $kurikulums = M_kurikulum::all()->reverse()->values();

            $jurusan_id = $request->jurusan_filter;
            if(isset($request->jurusan_filter) && $request->jurusan_filter != ""){
                // dd($request->jurusan_filter);
                $populations = M_Populations::where(['kurikulum_id' => $id, 'jurusan_id' => $jurusan_id ])->paginate(50) ;                
            }else{
                $populations = M_Populations::where('kurikulum_id', $id)->paginate(50);
            }

            $jurusans = M_jurusan::all();
            $dosens = M_dosen::where(["tersedia" => 1])->get();
            $matkuls = M_mata_kuliah::all();
            $ruangans = M_ruangan::all();
            $kelas_all = M_kelas::all();            
            $title = "Halaman Pengampu";
            
            $kelas = [];
            foreach ($populations as $key => $value) {
                // -> as it return std object
                $matkul_kelas = M_kelas::where('matkul_id',$value->kelas->matkul_id)->get();

                $index_search = -1;

                if(count($matkul_kelas) > 1){
                    // $index_search = array_search($value->kelas, $matkul_kelas);
                    foreach($matkul_kelas as $index_kelas => $matkul_kelas_val){       
                        // dd($matkul_kelas_val->id , $value->kelas->id);
                        if($matkul_kelas_val->id === $value->kelas->id){
                            $index_search = $index_kelas;
                            break;
                        }
                    }
                    
                    $kelas_group = count($matkul_kelas) > 1 ? " *) (".$alphabet[$index_search].")" : '';

                    $value->nama = $value->kelas->mataKuliah->nama . $kelas_group;
                    
                    $populations[$key] = $value;
                }else{
                    $value->nama = $value->kelas->mataKuliah->nama;
                    $populations[$key] = $value;
                }                
            }

            // dd($populations);

            $kelas_list = [];
            foreach ($kelas_all as $key => $value) {
                // -> as it return std object
                $kelas_list[$value->matkul_id][] = $value;
            }

            $kelas_list_final = [];
            foreach ($kelas_list as $mks){
                foreach ($mks as $index => $mk){
                    $kelas_group = count($mks) > 1 ? " *) (".$alphabet[$index].")" : '';

                    $mk->nama = $mk->mataKuliah->nama . $kelas_group;

                    
                    $kelas_list_final[] = $mk;
                }
            }
            // dd($kelas_list_final[5]);




            

            // dd($kelas_list);

            return view('admin.populations.pengampu', compact('jurusan_id','last_id','populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'kurikulums', 'id', 'kelas', 'alphabet', 'kelas_list','kelas_list_final'));
        }

        $title = 'Halaman Pengampu';
          

        $route_name = $request->route()->getName();
        // dd($route_name);

        return redirect()->route($route_name, ["kurikulum_id" => $last_id]);                
    }
    public function create(Request $request)
    {        

        $validatedData = $request->validate([
            'jurusan_id' => 'required|string',
            'kelas_id' => 'required|string',
            'dosen_id' => 'required',
            'kurikulum_id' => 'required'
        ]);

        
        
        $id = $request->kurikulum_id;
        $population_id= M_Populations::create($validatedData)->id;

        $data_dosen = [];
        foreach($request->dosen_id as $dosen){
            $data_dosen[] = [
                "population_id" => $population_id,
                "dosen_id" => $dosen,
            ];
        }
        
        // dd($data_dosen);
        M_population_dosen::insert($data_dosen);
        return back()->with([
            'success' => 'Data Gen berhasil ditambahkan',
            'kurikulum_id' => $id
        ]);
    }
    // controller
    public function edit($id)
    {
        $title = 'Populations';
        $population = M_Populations::findOrFail($id);
        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        $ruangans = M_ruangan::all();
        return view('admin.populations.edit', compact('title', 'population', 'jurusans', 'matkuls', 'ruangans', 'dosens'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jurusan_id' => 'required|string',
            'matkul_id' => 'required|string',
            'dosen_id' => 'required',
            // 'ruangan_id' => 'required|string',
        ]);

        M_population_dosen::where('population_id',$id)->delete();;

        $data_dosen = [];
        foreach($request->dosen_id as $dosen){
            $data_dosen[] = [
                "population_id" => $id,
                "dosen_id" => $dosen,
            ];
        }
        
        // dd($data_dosen);
        M_population_dosen::insert($data_dosen);
        $gen = M_Populations::findOrFail($id);
        $gen->update($validatedData);
        return redirect()->route('population')->with('success', 'Data Gen berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Temukan guru berdasarkan ID
        $gen = M_Populations::findOrFail($id);
        $gen->delete();
        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data gen telah dihapus');
    }
    public function generate(Request $request)
    {
        $kurikulum_id = $request->kurikulum_id;

        if (isset($kurikulum_id)) {
            $populations = M_Populations::where('kurikulum_id', $kurikulum_id)->get();
        } else {
            // Jika tidak ada kurikulum_id, ambil semua populasi
            $populations = M_Populations::all();
        }
        $rooms = M_ruangan::all()->toArray();
        // Konversi ke array
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $times = [
            ['07:15', '07:50'],
            ['07:50', '08:40'],
            ['08:40', '09:30'],
            ['09:30', '10:20'],
            ['10:20', '11:10'],
            ['11:10', '12:00'],
            ['12:00', '12:50'],
            ['12:50', '13:40'],
            ['13:40', '14:30'],
            ['14:30', '15:20'],
            ['15:20', '16:10'],
        ];

        $usedTimeslots = [];
        $generatePopulasi = []; // Array untuk menampung data jadwal yang di-generate
        $generatedScheduleIds = []; // Array untuk menampung data jadwal yang di-generate

        foreach ($populations as $population) {
            // Generate hari, waktu, dan ruangan secara acak tanpa konflik
            $foundSlot = false;
            shuffle($days);
            shuffle($times);
            shuffle($rooms);

            foreach ($days as $day) {
                foreach ($times as $time) {
                    foreach ($rooms as $room) {
                        // Periksa apakah ruangan bisa digunakan oleh jurusan atau apakah ruangan bersifat umum
                        if ($room['jurusan_id'] === null || $room['jurusan_id'] == $population->jurusan_id) {
                            $timeslot = "{$day}-{$time[0]}-{$time[1]}";

                            if (!isset($usedTimeslots[$population->dosen_id][$timeslot]) && !isset($usedTimeslots[$room['id']][$timeslot])) {
                                $foundSlot = true;

                                // Tandai slot waktu sebagai digunakan
                                $usedTimeslots[$population->dosen_id][$timeslot] = true;
                                $usedTimeslots[$room['id']][$timeslot] = true;

                                // Tambahkan data jadwal yang di-generate ke dalam array
                                $generatedScheduleIds[] = [
                                    'id' => $population->id,
                                    'dosen_id' => $population->dosen->id,
                                    'matkul_id' => $population->mataKuliah->id,
                                    'jurusan_id' => $population->jurusan->id,
                                    'ruangan_id' => $room['id'],
                                    'hari' => $day,
                                    'waktu_mulai' => $time[0],
                                    'waktu_selesai' => $time[1],
                                    'kurikulum_id' => $kurikulum_id
                                ];
                                $generatePopulasi[] = [
                                    'id' => $population->id,
                                    'dosen_id' => $population->dosen->nama,
                                    'matkul_id' => $population->mataKuliah->nama,
                                    'jurusan_id' => $population->jurusan->nama,
                                    'ruangan_id' => $room['nama'],
                                    'hari' => $day,
                                    'waktu_mulai' => $time[0],
                                    'waktu_selesai' => $time[1],
                                    'kurikulum_id' => $kurikulum_id
                                ];

                                break 3; // Keluar dari loop setelah menemukan slot
                            }
                        }
                    }
                }
            }

            if (!$foundSlot) {
                // Jika tidak menemukan slot, tambahkan log atau notifikasi
                error_log("Tidak dapat menemukan slot untuk dosen ID: {$population->dosen_id}");
            }
        }

        $generatedSchedules = collect($generatePopulasi);
        // Mengurutkan berdasarkan hari dan waktu mulai
        $dayOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        $sortedSchedules = $generatedSchedules->sort(function ($a, $b) use ($dayOrder) {
            $dayComparison = array_search($a['hari'], $dayOrder) <=> array_search($b['hari'], $dayOrder);
            if ($dayComparison === 0) {
                return strcmp($a['waktu_mulai'], $b['waktu_mulai']);
            }
            return $dayComparison;
        });
        session(['generatedScheduleIds' => $generatedScheduleIds]);
        // Redirect ke halaman tampilan dengan data jadwal yang di-generate
        $title = 'Populations';
        $populations = M_Populations::with(['jurusan', 'mataKuliah', 'dosen', 'ruangan'])->paginate(50);
        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        $ruangans = M_ruangan::all();
        $kurikulums = M_kurikulum::all();
        return view('admin.populations.generate', compact('populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'sortedSchedules', 'generatedScheduleIds', 'kurikulums'));
    }

    public function pengaturan_algoritma(){
        $title = 'Kelola Pengaturan Algoritma';

        $pengaturan = M_pengaturan_algoritma::first();
        
        return view('admin.populations.algoritma', compact('title', 'pengaturan'));
    }

    public function update_pengaturan_algoritma(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'umur' => 'required',
            'waktu' => 'required',
            
        ]);

        // Cari ruangan berdasarkan ID
        $pengaturan = M_pengaturan_algoritma::findOrFail(1);

        // Update data pengaturan
        $pengaturan->umur = $validatedData['umur'];
        $pengaturan->waktu = $validatedData['waktu'];                

        // Simpan perubahan
        $pengaturan->save();

        // Jika penyimpanan berhasil, kembalikan respons berhasil
        return back()->with('success', 'Data Pengaturan algoritma berhasil diperbarui.');
    }

    public function slot(){
        $title = 'Kelola Slot Waktu';
        $users = M_slot_waktu::paginate(10);
        return view('admin.populations.slot', compact('title', 'users'));
    }

    public function edit_slot($id)
    {
        $title = 'Edit slot waktu';
        $slot = M_slot_waktu::findOrFail($id);
        
        return view('admin.populations.editSlot', compact('title', 'slot'));
    }

    public function update_slot(Request $request, $id)
    {
        $validatedData = $request->validate([
            'time' => 'required|unique:time_slot',             
            // 'ruangan_id' => 'required|string',
        ]);                        
        
        $slot = M_slot_waktu::findOrFail($id);
        $slot->update($validatedData);
        return redirect()->route('slot')->with('success', 'Data slot waktu berhasil diperbarui.');
    }

    public function add_slot(Request $request){
        
        $validatedData = $request->validate([
            'time' => 'required|unique:time_slot',            
        ]);
        
        // dd($data_dosen);
        M_slot_waktu::insert([
            'time' => $request->time
        ]);

        return back()->with('success', 'Data waktu telah ditambah');
    }

    public function delete_slot($id)
    {
        // Temukan guru berdasarkan ID
        $gen = M_slot_waktu::findOrFail($id);
        $gen->delete();
        // Simpan pesan berhasil ke dalam session
        return redirect()->back()->with('success', 'Data waktu telah dihapus');
    }

    public function saveSchedules(Request $request)
    {
        // Ambil data sortedSchedules dari request
        $sortedSchedules = json_decode($request->input('sortedSchedules'), true);
        // Update tabel population berdasarkan sortedSchedules
        foreach ($sortedSchedules as $schedule) {
            $population = M_Populations::where([
                'jurusan_id' => $schedule['jurusan_id'],
                'matkul_id' => $schedule['matkul_id'],
                'dosen_id' => $schedule['dosen_id']
            ])->first();
            if ($population) {
                $population->update([
                    'ruangan_id' => $schedule['ruangan_id'],
                    'hari' => $schedule['hari'],
                    'waktu_mulai' => $schedule['waktu_mulai'],
                    'waktu_selesai' => $schedule['waktu_selesai'],
                    'kurikulum_id' => $schedule['kurikulum_id'],
                ]);
            }
        }
        return redirect()->route('population')->with('success', 'Jadwal berhasil disimpan.');
    }

    // download xsxl
    public function export()
    {
        return Excel::download(new Export_Jadwal, 'population.xlsx');
    }

    public function exportTemplate()
    {
        return Excel::download(new Export_Template_Pengampu, 'template-pengampu.xlsx');
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
		Excel::import(new JadwalImport, $file);
 
		// alihkan halaman kembali
		return back()->with('success','Data Dosen Berhasil Diimport!');
	
    }
}
