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
        if (isset($kurikulum_id)) {
            $populations = M_Populations::where('kurikulum_id', $kurikulum_id)->get()->toArray();
        } else {
            $populations = M_Populations::all()->toArray();
        }
        $ga = new GeneticAlgorithm(100, 0.02, 10, 100, $populations, $rooms);
        $result = $ga->run();
        dd($result);
        $bestSchedule = $result['bestSchedule'];
        $finalFitness = $result['finalFitness'];
        $fitnessHistory = $result['fitnessHistory'];

        return view('schedule.result', compact('bestSchedule', 'finalFitness', 'fitnessHistory'));
    }
}
