<?php

namespace App\Http\Controllers;

use App\Models\M_Populations;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Phpml\Classification as Chromosome;

class Controller_jadwal_kuliah extends Controller
{
    public function geneticAlgorithm(Request $request)
    {
        $kurikulum_id = $request->kurikulum_id;
        if (isset($kurikulum_id)) {
            $populations = M_Populations::where('kurikulum_id', $kurikulum_id)->get()->toArray();
        } else {
            $populations = M_Populations::all()->toArray();
        }

        // Inisialisasi parameter algoritma genetika
        $maxGenerations = 100;
        $crossoverRate = 0.8;
        $mutationRate = 0.02;

        // Inisialisasi populasi
        $currentPopulation = $this->initializePopulation($populations);

        // Iterasi algoritma genetika
        $fitnessHistory = [];
        for ($generation = 0; $generation < $maxGenerations; $generation++) {
            // Evaluasi populasi
            $fitnessValues = $this->evaluatePopulation($currentPopulation);
            $fitnessHistory[] = $fitnessValues;

            // Seleksi
            $selectedPopulation = $this->selection($currentPopulation, $fitnessValues);

            // Crossover
            $newPopulation = $this->crossover($selectedPopulation, $crossoverRate);

            // Mutasi
            $mutatedPopulation = $this->mutation($newPopulation, $mutationRate);

            // Generasi baru
            $currentPopulation = $mutatedPopulation;
        }

        // Evaluasi populasi terakhir
        $finalFitnessValues = $this->evaluatePopulation($currentPopulation);

        // Ambil solusi terbaik
        $bestSolution = $this->getBestSolution($currentPopulation, $finalFitnessValues);

        return view('population.result', compact('bestSolution', 'finalFitnessValues', 'fitnessHistory'));
    }

    private function initializePopulation(array $populations)
    {
        return array_map(function ($population) {
            return [
                'id' => $population['id'],
                'dosen_id' => $population['dosen_id'],
                'matkul_id' => $population['matkul_id'],
                'jurusan_id' => $population['jurusan_id'],
                'ruangan_id' => $population['ruangan_id'],
                'hari' => $population['hari'],
                'waktu_mulai' => $population['waktu_mulai'],
                'waktu_selesai' => $population['waktu_selesai'],
                'kurikulum_id' => $population['kurikulum_id'],
                'created_at' => $population['created_at'],
                'updated_at' => $population['updated_at'],
            ];
        }, $populations);
    }

    private function evaluatePopulation(array $population)
    {
        return array_map(function ($individual) use ($population) {
            return $this->calculateFitness($individual, $population);
        }, $population);
    }

    private function selection(array $population, array $fitnessValues)
    {
        $selectedPopulation = [];
        $tournamentSize = 3; // ukuran turnamen

        for ($i = 0; $i < count($population); $i++) {
            $tournament = [];
            for ($j = 0; $j < $tournamentSize; $j++) {
                $randomIndex = array_rand($population);
                $tournament[] = ['individual' => $population[$randomIndex], 'fitness' => $fitnessValues[$randomIndex]];
            }

            // Cari individu dengan nilai fitness terbaik dalam turnamen
            usort($tournament, function ($a, $b) {
                return $b['fitness'] <=> $a['fitness'];
            });

            $selectedPopulation[] = $tournament[0]['individual'];
        }

        return $selectedPopulation;
    }

    private function crossover(array $selectedPopulation, $crossoverRate)
    {
        $newPopulation = [];

        for ($i = 0; $i < count($selectedPopulation); $i += 2) {
            if (mt_rand() / mt_getrandmax() < $crossoverRate) {
                $parent1 = $selectedPopulation[$i];
                $parent2 = $selectedPopulation[$i + 1] ?? $selectedPopulation[0]; // jika jumlah individu ganjil

                // Single-point crossover
                $crossoverPoint = array_rand($parent1);

                $child1 = array_merge(
                    array_slice($parent1, 0, $crossoverPoint, true),
                    array_slice($parent2, $crossoverPoint, null, true)
                );

                $child2 = array_merge(
                    array_slice($parent2, 0, $crossoverPoint, true),
                    array_slice($parent1, $crossoverPoint, null, true)
                );

                $newPopulation[] = $child1;
                $newPopulation[] = $child2;
            } else {
                $newPopulation[] = $selectedPopulation[$i];
                if (isset($selectedPopulation[$i + 1])) {
                    $newPopulation[] = $selectedPopulation[$i + 1];
                }
            }
        }

        return $newPopulation;
    }

    private function mutation(array $population, $mutationRate)
    {
        foreach ($population as &$individual) {
            if (mt_rand() / mt_getrandmax() < $mutationRate) {
                // Mutasi random: mengubah hari atau waktu mulai secara acak
                $keys = array_keys($individual);
                $keyToMutate = $keys[array_rand($keys)];
                if ($keyToMutate == 'hari') {
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $individual[$keyToMutate] = $days[array_rand($days)];
                } elseif ($keyToMutate == 'waktu_mulai' || $keyToMutate == 'waktu_selesai') {
                    $times = [
                        '07:15:00', '07:50:00', '08:40:00', '09:30:00', '10:20:00',
                        '11:10:00', '12:00:00', '12:50:00', '13:40:00', '14:30:00', '15:20:00'
                    ];
                    $individual[$keyToMutate] = $times[array_rand($times)];
                }
            }
        }

        return $population;
    }

    private function getBestSolution(array $population, array $fitnessValues)
    {
        // Temukan indeks dari nilai fitness terbaik
        $bestIndex = array_keys($fitnessValues, max($fitnessValues))[0];

        // Ambil individu terbaik berdasarkan indeks
        return $population[$bestIndex];
    }




}
