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
        $kurikulum_id = $request->kurikulum_id;

        // Fetch rooms and populations based on the curriculum ID
        $rooms = M_ruangan::all()->toArray();
        $populationsQuery = M_Populations::with('dosen');

        if ($kurikulum_id) {
            $populationsQuery->where('kurikulum_id', $kurikulum_id);
        }

        $populations = $populationsQuery->get()->toArray();
        $jadwal = M_Populations::where('kurikulum_id', $kurikulum_id)->get();

        // Ensure populations are available before running the Genetic Algorithm
        if (empty($populations)) {
            return back()->withErrors(["message" => "No populations found for the selected curriculum."]);
        }

        $ga = new GeneticAlgorithm(50, 0.02, 20, 5, $populations, $rooms, 0.002);
        $result = $ga->run();

        $bestSchedule = $result['bestSchedule'];        

        foreach ($bestSchedule as $i => $population) {
            if (isset($jadwal[$i])) {
                $jadwal[$i]->fill([
                    'ruangan_id' => $population['ruangan_id'],
                    'hari' => $population['hari'],
                    'waktu_mulai' => $population['waktu_mulai'],
                    'waktu_selesai' => $population['waktu_selesai'],
                ]);

                try {
                    $jadwal[$i]->save();
                } catch (\Exception $e) {
                    \Log::error('Failed to save jadwal: ' . $e->getMessage());
                }
            }
        }

        return back()->with(["success generate" => true]);
    }

    
}
