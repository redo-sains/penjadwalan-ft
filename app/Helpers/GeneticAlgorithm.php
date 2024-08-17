<?php

namespace App\Helpers;

use App\Models\M_mata_kuliah;
use App\Models\M_population_dosen;

class GeneticAlgorithm
{
    private $populationSize;
    private $mutationRate;
    private $eliteCount;
    private $generations;
    private $populations;
    private $daysInWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    private $timeSlots = ['07:50:00', '09:30:00', '10:20:00', '12:00:00', '12:50:00', '15:20:00'];
    private $rooms; // Rooms will be set via the constructor

    public function __construct($populationSize, $mutationRate, $eliteCount, $generations, $populations, $rooms)
    {
        $this->populationSize = $populationSize;
        $this->mutationRate = $mutationRate;
        $this->eliteCount = $eliteCount;
        $this->generations = $generations;
        $this->populations = $populations;
        $this->rooms = $rooms;
    }

    public function run()
    {
        $population = $this->initializePopulation();
        $fitnessHistory = [];

        for ($i = 0; $i < $this->generations; $i++) {
            $fitnessValues = $this->evaluatePopulation($population);
            $fitnessHistory[] = $fitnessValues;

            $population = $this->evolvePopulation($population);
        }

        $finalFitness = $this->evaluatePopulation($population);
        $bestSchedule = $this->getBestSchedule($population);

        return [
            'bestSchedule' => $bestSchedule,
            'finalFitness' => $finalFitness,
            'fitnessHistory' => $fitnessHistory
        ];
    }

    private function initializePopulation()
    {
        $population = [];

        for ($i = 0; $i < $this->populationSize; $i++) {
            $schedule = [];

            foreach ($this->populations as $course) {

                $sks = M_mata_kuliah::find($course['matkul_id'])->sks;                

                $day = $this->daysInWeek[array_rand($this->daysInWeek)];
                $timeSlot = $this->timeSlots[array_rand($this->timeSlots)];

                $filteredRooms = array_filter($this->rooms, function ($room) use ($course) {
                    return $room['jurusan_id'] === null || $room['jurusan_id'] == $course['jurusan_id'];
                });

                if (empty($filteredRooms)) {
                    // Handle case where no room matches the course's department
                    error_log("No available rooms for course ID: {$course['id']}");
                    continue;
                }

                $room = $filteredRooms[array_rand($filteredRooms)];

                $course['hari'] = $day;
                $course['waktu_mulai'] = $timeSlot;
                $course['waktu_selesai'] = date('H:i:s', strtotime($timeSlot) + (50 * 60 * $sks) ); // 50 minutes later
                $course['ruangan_id'] = $room['id'];

                $schedule[] = $course;
            }

            $population[] = $schedule;
        }

        return $population;
    }
    private function evolvePopulation($population)
    {
        $newPopulation = [];

        for ($i = 0; $i < $this->eliteCount; $i++) {
            $newPopulation[] = $population[$i];
        }

        while (count($newPopulation) < $this->populationSize) {
            $parent1 = $this->selectParent($population);
            $parent2 = $this->selectParent($population);
            $child = $this->crossover($parent1, $parent2);
            $child = $this->mutate($child);
            $newPopulation[] = $child;
        }

        return $newPopulation;
    }

    private function selectParent($population)
    {
        $index = rand(0, count($population) - 1);
        return $population[$index];
    }

    private function crossover($parent1, $parent2)
    {
        $child = [];
        $splitPoint = rand(1, count($parent1) - 1);

        for ($i = 0; $i < $splitPoint; $i++) {
            $child[] = $parent1[$i];
        }

        for ($i = $splitPoint; $i < count($parent2); $i++) {
            $child[] = $parent2[$i];
        }

        return $child;
    }

    private function mutate($schedule)
    {
        foreach ($schedule as &$course) {
            if (mt_rand(0, 100) / 100 < $this->mutationRate) {
                $course['hari'] = $this->daysInWeek[array_rand($this->daysInWeek)];
                $course['waktu_mulai'] = $this->timeSlots[array_rand($this->timeSlots)];
                $course['waktu_selesai'] = date('H:i:s', strtotime($course['waktu_mulai']) + 50 * 60); // 50 menit kemudian

                // Filter ruangan berdasarkan jurusan_id
                $filteredRooms = array_filter($this->rooms, function ($room) use ($course) {
                    return $room['jurusan_id'] === null || $room['jurusan_id'] == $course['jurusan_id'];
                });

                if (!empty($filteredRooms)) {
                    $course['ruangan_id'] = $filteredRooms[array_rand($filteredRooms)]['id'];
                } else {
                    // Jika tidak ada ruangan yang cocok, log error atau pilih ruangan default
                    error_log("Tidak ada ruangan yang cocok untuk course ID: {$course['id']}");
                    $course['ruangan_id'] = $this->rooms[array_rand($this->rooms)]['id'];
                }
            }
        }

        return $schedule;
    }


    private function getBestSchedule($population)
    {
        $bestFitness = PHP_INT_MAX;
        $bestSchedule = null;

        foreach ($population as $schedule) {
            // dd($schedule);
            $fitness = $this->calculateFitness($schedule);

            if ($fitness < $bestFitness) {
                $bestFitness = $fitness;
                $bestSchedule = $schedule;
            }
        }

        return $bestSchedule;
    }

    private function evaluatePopulation($population)
    {
        $fitnessValues = [];

        foreach ($population as $schedule) {
            $fitnessValues[] = $this->calculateFitness($schedule);
        }

        return $fitnessValues;
    }

    private function calculateFitness($schedule)
    {
        $overlapCount = $this->calculateOverlap($schedule);
        $fitness = $overlapCount;

        return $fitness;
    }

    private function calculateOverlap($schedule)
    {              
        $overlapCount = 0;

        foreach ($schedule as $i => $course1) {
            foreach ($schedule as $j => $course2) {
                if ($i != $j) {                    
                    
                    $dosen_check = false;

                    foreach($course1['dosen'] as $dos1){
                        
                        foreach($course2['dosen'] as $dos2){
                            if($dos1['dosen_id'] == $dos2['dosen_id'] ){
                                $dosen_check == true;
                            }
                        }
                        
                    }
                    // dd($dosen_check , $arr_id_dosen1, $arr_id_dosen2);                    


                    if (

                        $dosen_check &&
                        $course1['hari'] == $course2['hari'] &&
                        $course1['waktu_mulai'] == $course2['waktu_mulai']
                    ) {
                        $overlapCount++;
                    }

                    if (
                        $course1['ruangan_id'] == $course2['ruangan_id'] &&
                        $course1['hari'] == $course2['hari'] &&
                        $course1['waktu_mulai'] == $course2['waktu_mulai']
                    ) {
                        $overlapCount++;
                    }
                }
            }
        }

        return $overlapCount;
    }
}
