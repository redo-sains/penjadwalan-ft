<?php

namespace App\Http\Controllers;

use App\Exports\Export_Jadwal;
use App\Models\M_dosen;
use App\Models\M_jurusan;
use App\Models\M_kurikulum;
use App\Models\M_mata_kuliah;
use App\Models\M_population_dosen;
use App\Models\M_Populations;
use App\Models\M_ruangan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Controller_populations extends Controller
{
    //
    public function show(Request $request)
    {
        if (isset($request->kurikulum_id)) {
            $validatedData = $request->validate([
                'kurikulum_id' => 'required'
            ]);
            $id = $request->kurikulum_id;

            $kurikulums = M_kurikulum::all();
            $populations = M_Populations::where('kurikulum_id', $id)->paginate(8);
            $jurusans = M_jurusan::all();
            $dosens = M_dosen::where(["tersedia" => 1])->get();
            $matkuls = M_mata_kuliah::all();
            $ruangans = M_ruangan::all();
            // $kurikulums = M_kurikulum::all();
            $title = "Halaman Populasi";

            return view('admin.populations.index', compact('populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'kurikulums', 'id'));
        }

        $title = 'Populations';
        $populations = M_Populations::with(['jurusan', 'mataKuliah', 'dosen', 'ruangan'])->paginate(10);
        // $populations = M_Populations::with(['jurusan', 'mataKuliah',  'ruangan'])->first();
        // dd($populations);

        // $test = $populations[0]->dosen->map(
        //     function ($dos){
        //         return $dos->dosen->nama;
        //     }
        // )->toArray();

        // $test = implode(", ", $test);
        // dd($test);


        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        $ruangans = M_ruangan::all();
        $kurikulums = M_kurikulum::all();

        return view('admin.populations.index', compact('populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'kurikulums'));
    }

    public function pengampu(Request $request)
    {
        if (isset($request->kurikulum_id)) {
            $validatedData = $request->validate([
                'kurikulum_id' => 'required'
            ]);
            $id = $request->kurikulum_id;

            $kurikulums = M_kurikulum::all();
            $populations = M_Populations::where('kurikulum_id', $id)->paginate(8);
            $jurusans = M_jurusan::all();
            $dosens = M_dosen::where(["tersedia" => 1])->get();
            $matkuls = M_mata_kuliah::all();
            $ruangans = M_ruangan::all();
            // $kurikulums = M_kurikulum::all();
            $title = "Halaman Pengampu";

            return view('admin.populations.pengampu', compact('populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'kurikulums', 'id'));
        }

        $title = 'Halaman Pengampu';
        $populations = M_Populations::with(['jurusan', 'mataKuliah', 'dosen', 'ruangan'])->paginate(10);
        // $populations = M_Populations::with(['jurusan', 'mataKuliah',  'ruangan'])->first();
        // dd($populations);

        // $test = $populations[0]->dosen->map(
        //     function ($dos){
        //         return $dos->dosen->nama;
        //     }
        // )->toArray();

        // $test = implode(", ", $test);
        // dd($test);


        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        $ruangans = M_ruangan::all();
        $kurikulums = M_kurikulum::all();

        return view('admin.populations.pengampu', compact('populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'kurikulums'));
    }
    public function create(Request $request)
    {

        // dd($request->dosen_id);

        $validatedData = $request->validate([
            'jurusan_id' => 'required|string',
            'matkul_id' => 'required|string',
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
        $populations = M_Populations::with(['jurusan', 'mataKuliah', 'dosen', 'ruangan'])->paginate(10);
        $jurusans = M_jurusan::all();
        $dosens = M_dosen::all();
        $matkuls = M_mata_kuliah::all();
        $ruangans = M_ruangan::all();
        $kurikulums = M_kurikulum::all();
        return view('admin.populations.generate', compact('populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'sortedSchedules', 'generatedScheduleIds', 'kurikulums'));
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
}
