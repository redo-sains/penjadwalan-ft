<?php

namespace App\Http\Controllers;

use App\Helpers\GeneticAlgorithm;
use Illuminate\Http\Request;
use App\Models\M_Populations;
use App\Models\M_ruangan;

class Controller_Perhitungan extends Controller
{
    public function generateSchedule(Request $request)
    {
        $rooms = M_ruangan::all()->toArray();
        $kurikulum_id = $request->kurikulum_id;

        // M_Populations::where('kurikulum_id', $kurikulum_id)->delete();        

        if (isset($kurikulum_id)) {
            $populations = M_Populations::where('kurikulum_id', $kurikulum_id)->with('dosen')->get()->toArray();
            $jadwal = M_Populations::where('kurikulum_id', $kurikulum_id)->get();
        } else {
            $populations = M_Populations::with('dosen')->all()->toArray();
            $jadwal = M_Populations::all();
        }
        // dd($rooms);
        $ga = new GeneticAlgorithm(100, 0.02, 10, 50, $populations, $rooms);
        $result = $ga->run();

        
        $bestSchedule = $result['bestSchedule'];

        
        foreach($bestSchedule as $i=>$population){
            // dd($population['ruangan_id'], $jadwal[$i]);
            $jadwal[$i]->ruangan_id = $population['ruangan_id'];
            $jadwal[$i]->hari = $population['hari'];
            $jadwal[$i]->waktu_mulai = $population['waktu_mulai'];
            $jadwal[$i]->waktu_selesai = $population['waktu_selesai'];

            $jadwal[$i]->save();
        }
        // dd($bestSchedule, $jadwal);        
        // $jadwal->save();

        return back()->with(["success generate" => true]);
    }
}
