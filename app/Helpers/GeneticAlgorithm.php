<?php

namespace App\Helpers;

use App\Models\M_dosen;
use App\Models\M_kelas;
use App\Models\M_mata_kuliah;
use App\Models\M_pengaturan_algoritma;
use App\Models\M_population_dosen;
use App\Models\M_slot_waktu;
use DateTime;

class GeneticAlgorithm
{
    private $populationSize;
    private $mutationRate;
    private $eliteCount;
    private $generations;
    private $populations;
    private $rooms;
    private $crossoverRate;

    private $daysInWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    private $timeSlots = [];
    private $umur;
    private $batas_waktu;
    
    
    public function __construct($populationSize, $mutationRate, $eliteCount, $generations, $populations, $rooms, $crossoverRate)
    {
        $this->timeSlots = M_slot_waktu::all()->pluck('time')->toArray();
        $this->umur = M_pengaturan_algoritma::first()->umur;
        $this->batas_waktu = M_pengaturan_algoritma::first()->waktu;
        $this->populationSize = $populationSize;
        $this->mutationRate = $mutationRate;
        $this->eliteCount = $eliteCount;
        $this->generations = $generations;
        $this->populations = $populations;
        $this->rooms = $rooms;
        $this->crossoverRate = $crossoverRate; // Initialize crossover rate
    }


    public function run()
    {
        $population = $this->initializePopulation();
        $bestIndex = -1; // Initialize best index
        $bestFitness = PHP_INT_MIN; // Start with the lowest possible fitness value
        $fitnessHistory = []; // To store history of fitness values

        for ($i = 0; $i < $this->generations; $i++) {


            $fitnessValues = $this->evaluatePopulation($population);

            // Record the fitness values for this generation
            $fitnessHistory[] = $fitnessValues;

            // Find the best index and its fitness in the current population
            foreach ($fitnessValues as $index => $fitness) {
                if ($fitness > $bestFitness) {
                    $bestFitness = $fitness;
                    $bestgeneration = $i;
                    $bestIndex = $index;
                }
            }

            // Evolve the population for the next generation
            $population = $this->evolvePopulation($population, $fitnessValues);
        }

        // After all generations, get the best schedule
        $finalBestSchedule = $population[$bestIndex];
        $finalFitness = $bestFitness;

        $finalBestSchedule = $population[$bestIndex];
        // $this->handleOverlaps($finalBestSchedule);        

        return [
            'bestSchedule' => $finalBestSchedule,
            'finalFitness' => $finalFitness,
            'generation' => $bestgeneration, // Return the last generation number
            'bestIndex' => $bestIndex, // Return the index of the best schedule
            'fitnessHistory' => $fitnessHistory // Return the history of fitness values
        ];
    }

    private function initializePopulation()
    {
        return array_map(function () {
            $schedule = [];
            $usedSlots = [];
            $courseCodes = [];
            $femaleTime = [];

            foreach ($this->populations as $course) {
                $kelas = M_kelas::find($course['kelas_id']);
                
                
                $subject = M_mata_kuliah::find($kelas->matkul_id);

                $sks = $subject->sks;
                $filteredRooms = $this->getFilteredRooms($course);

                // Check lecturer conditions
                $lecturers = $course['dosen'];
                $hasFemaleLecturer = false;
                $hasOlderLecturer = false;

                foreach ($lecturers as $lecturer) {
                    $lecturer = M_dosen::find($lecturer['dosen_id']);
                    $d1 = new DateTime();
                    $d2 = new DateTime($lecturer['umur']);

                    $diff = $d2->diff($d1);

                    $umur_dosen = $diff->y;
                    if ($lecturer['gender'] === 'female') {                        
                        $hasFemaleLecturer = true;
                    }
                    if ($umur_dosen >= $this->umur) {
                        $hasOlderLecturer = true;
                    }
                }

                // Randomly select day and time slot
                $day = $this->daysInWeek[array_rand($this->daysInWeek)];
                $timeSlot = '';
                do {
                    $timeSlot = $this->timeSlots[array_rand($this->timeSlots)];
                } while ($hasFemaleLecturer && new \DateTime($timeSlot) < new \DateTime($this->batas_waktu));

                $endTime = $this->calculateEndTime($timeSlot, $sks);

                // $course[''] = 

                
                // Filter rooms for older lecturers
                if ($hasOlderLecturer) {
                    $filteredRooms = array_filter($filteredRooms, function ($room) {
                        return $room['lantai'] === 1;
                    });
                }
                if ($hasFemaleLecturer === true) {                        
                    $course['waktu_mulai'] = $timeSlot;
                    $course['waktu_selesai'] = $endTime;
                    // dd($course);
                    
                }

                if (empty($filteredRooms)) {
                    error_log("No available rooms for course ID: {$course['id']}");
                    continue;
                }

                $courseCode = $subject['kode'];
                if (!isset($courseCodes[$courseCode])) {
                    $courseCodes[$courseCode] = [];
                }

                $validRoomAssigned = false;

                // Schedule with overlap check
                $this->assignCourse($course, $filteredRooms, $day, $timeSlot, $endTime, $usedSlots, $courseCodes, $schedule, $validRoomAssigned);
                
            }
            
            $this->rescheduleOverlappingCourses($schedule);

            return $schedule;
        }, range(1, $this->populationSize));
    }

    private function rescheduleOverlappingCourses(&$schedule)
    {

        // $original = $schedule;        
        // Group courses by day
        $calculateOverlap1 = $this->calculateOverlap($schedule);                

        $trackOverlap = [];

        // Iterate over each day


        while ($calculateOverlap1['overlap_count'] > 0) {

            $groupedByDay = [];
            foreach ($schedule as $course) {
                $groupedByDay[$course['hari']][] = $course;
            }

            foreach ($groupedByDay as $day => $courses) {
                // Check for overlaps within the same day
                $calculateOverlapCourse = $this->calculateOverlap($courses);

                $overlappingCourses =  array_unique(array_map(function ($elem) {
                    return $elem;
                }, $calculateOverlapCourse['overlap_schedule']), SORT_REGULAR);


                // dd($overlappingCourses);

                $overlappingCourses_before = $schedule;
                $id_change = [];



                foreach ($overlappingCourses as $overlappingCourse) {
                    // Get filtered rooms for the overlapping course

                    $calculateOverlapTest = $this->calculateOverlap($schedule);

                    $index_search = array_search($overlappingCourse, $schedule);

                    // dd($index_search, $schedule[$index_search]);

                    $filteredRooms = $this->getFilteredRooms($overlappingCourse);

                    // Find available space for this course                    
                    $kelas = M_kelas::find($overlappingCourse['kelas_id']);                                            

                    $sks = M_mata_kuliah::find($kelas->matkul_id)->sks; // Assuming you have the course ID
                    $availableSpaces = $this->getAvailableSpace($filteredRooms, $schedule, $sks);

                    $schedule_before = $schedule[$index_search];

                    if (!empty($availableSpaces)) {
                        foreach ($availableSpaces as $space) {
                            $schedule[$index_search]['hari'] = $space['day'];
                            $schedule[$index_search]['waktu_mulai'] = $space['timeSlot'];
                            $schedule[$index_search]['waktu_selesai'] = $space['endTime'];
                            $schedule[$index_search]['ruangan_id'] = $space['roomId'];

                            // dd($schedule);

                            $checkOverlap = $this->calculateOverlap($schedule);


                            if ($checkOverlap['overlap_count'] < $calculateOverlapTest['overlap_count']) {
                                // dd($checkOverlap['overlap_count'] ,$calculateOverlapTest['overlap_count']);
                                $trackOverlap[] = [
                                    "after" => $checkOverlap['overlap_count'],
                                    "before" => $calculateOverlapTest['overlap_count'],
                                ];
                                break;
                            }
                        }
                        // Update the course details


                        // Update the schedule with the new assignment
                        $id_change[] = $index_search;
                        // dd($schedule_before, $schedule[$index_search]);
                    } else {
                        error_log("No available slots found for course ID: {$overlappingCourse['id']}");
                    }
                }

                $overlappingCourses_after = $schedule;
            }
            $calculateOverlap1 = $this->calculateOverlap($schedule);            
        }
        
    }

    private function getAvailableSpace($filteredRooms, &$schedule, $sks)
    {
        $availableSpaces = []; // To hold available slots

        // Iterate over each day
        foreach ($this->daysInWeek as $day) {
            // Iterate over each time slot
            foreach ($this->timeSlots as $timeSlot) {
                $endTime = $this->calculateEndTime($timeSlot, $sks); // Pass SKS directly

                foreach ($filteredRooms as $room) {
                    // Check if this room is already scheduled for the given day and time
                    $isRoomAvailable = true;

                    // Check for overlaps with existing courses in this room
                    foreach ($schedule as $existingCourse) {
                        if ($existingCourse['ruangan_id'] === $room['id'] && $existingCourse['hari'] === $day) {
                            // Check for time overlap
                            if ($this->timesOverlap($timeSlot, $endTime, $existingCourse['waktu_mulai'], $existingCourse['waktu_selesai'])) {
                                $isRoomAvailable = false;
                                break; // Exit on first overlap
                            }
                        }
                    }

                    // If room is available, add it to the available spaces
                    if ($isRoomAvailable) {
                        $availableSpaces[] = [
                            'day' => $day,
                            'timeSlot' => $timeSlot,
                            'roomId' => $room['id'],
                            'endTime' => $endTime,
                        ];
                    }
                }
            }
        }

        return $availableSpaces; // Return all available slots
    }

    private function assignCourse(&$course, $filteredRooms, $day, $timeSlot, $endTime, &$usedSlots, &$courseCodes, &$schedule, &$validRoomAssigned)
    {
        // Check if there are already scheduled courses with the same code

        $kelas = M_kelas::find($course['kelas_id']);                                                        

        $courseCode = M_mata_kuliah::find($kelas->matkul_id)['kode'];

        if (empty($courseCodes[$courseCode])) {
            // No overlap, try to schedule
            foreach ($filteredRooms as $room) {
                $key = "{$day}_{$room['id']}";
                $valid = $this->checkAndAssign($course, $room, $day, $timeSlot, $endTime, $usedSlots, $key, $validRoomAssigned, $schedule, $courseCodes);
                if ($valid) break; // Exit if successfully assigned
            }
        } else {

            $firstCourseId = 0;

            $merge_course = array_merge($courseCodes[$courseCode], [$course]);

            
            foreach ($merge_course as $courseId => $courseTemp) {

                $hasFemaleLecturer = false;
                
                foreach ($courseTemp['dosen'] as $lecturer) {
    
                    $lecturer = M_dosen::find($lecturer['dosen_id']);
                    if ($lecturer['gender'] === 'female') {                        
                        $hasFemaleLecturer = true;
                        break;
                    }                

                }

                if($hasFemaleLecturer == true){
                    $firstCourseId = $courseId;
                    break;
                }
            }


            // For courses with the same code, try to schedule at the same time but different rooms
            $firstCourse = $merge_course[$firstCourseId];
            $day = $firstCourse['hari'];
            $timeSlot = $firstCourse['waktu_mulai'];
            $endTime = $firstCourse['waktu_selesai'];

            foreach ($filteredRooms as $room) {
                $key = "{$day}_{$room['id']}";
                $valid = $this->checkAndAssign($course, $room, $day, $timeSlot, $endTime, $usedSlots, $key, $validRoomAssigned, $schedule, $courseCodes);
                if ($valid) break; // Exit if successfully assigned
            }
        }

        // If no valid room was assigned, try to find an alternative schedule
        if (!$validRoomAssigned) {
            $this->findAlternativeSchedule($course, $filteredRooms, $usedSlots, $courseCodes, $schedule);
        }
    }

    private function checkAndAssign(&$course, $room, $day, $timeSlot, $endTime, &$usedSlots, $key, &$validRoomAssigned, &$schedule, &$courseCodes)
    {
        if (!isset($usedSlots[$key])) {
            $usedSlots[$key] = [];
        }

        // Check if current time slot overlaps with any existing courses
        foreach ($usedSlots[$key] as $existingCourse) {
            if ($this->timesOverlap($timeSlot, $endTime, $existingCourse['waktu_mulai'], $existingCourse['waktu_selesai'])) {
                return false; // Overlap detected
            }
        }

        $kelas = M_kelas::find($course['kelas_id']);                                                        

        // $courseCode = M_mata_kuliah::find($kelas->matkul_id)['kode'];

        // Check room capacity
        $subject = M_mata_kuliah::find($kelas->matkul_id);
        $numberParticipant = $subject->jumlah;
        if ($room['kapasitas'] >= $numberParticipant) {
            // Assign values
            $course['hari'] = $day;
            $course['waktu_mulai'] = $timeSlot;
            $course['waktu_selesai'] = $endTime;
            $course['ruangan_id'] = $room['id'];

            // Track the slot usage by room
            $usedSlots[$key][] = $course;
            $validRoomAssigned = true;

            // Schedule this course for future reference
            $courseCodes[$subject['kode']][] = $course;
            $schedule[] = $course; // Add to the final schedule
            // if($numberParticipant == 145){
            //     dd($room);
            // }
            return true; // Successful assignment
        }


        return false; // No valid assignment
    }

    private function findAlternativeSchedule(&$course, $filteredRooms, &$usedSlots, &$courseCodes, &$schedule)
    {
        // Iterate over each day and time slot to find a suitable alternative
        foreach ($this->daysInWeek as $day) {
            foreach ($this->timeSlots as $timeSlot) {
                $kelas = M_kelas::find($course['kelas_id']);                                                        
        
                $endTime = $this->calculateEndTime($timeSlot, M_mata_kuliah::find($kelas->matkul_id)->sks);

                foreach ($filteredRooms as $room) {
                    $key = "{$day}_{$room['id']}";
                    if (!isset($usedSlots[$key])) {
                        $usedSlots[$key] = [];
                    }

                    // Check if current time slot overlaps with any existing courses
                    $valid = true;
                    foreach ($usedSlots[$key] as $existingCourse) {
                        if ($this->timesOverlap($timeSlot, $endTime, $existingCourse['waktu_mulai'], $existingCourse['waktu_selesai'])) {
                            $valid = false;
                            break;
                        }
                    }

                    $kelas = M_kelas::find($course['kelas_id']);                                                        
                                            
                    $subject = M_mata_kuliah::find($kelas->matkul_id);
                    $numberParticipant = $subject->jumlah;
                    if ($valid && $room['kapasitas'] >= $numberParticipant) {
                        // Assign new values
                        $course['hari'] = $day;
                        $course['waktu_mulai'] = $timeSlot;
                        $course['waktu_selesai'] = $endTime;
                        $course['ruangan_id'] = $room['id'];

                        // Track the slot usage
                        $usedSlots[$key][] = $course;
                        $courseCodes[$subject['kode']][] = $course;
                        $schedule[] = $course; // Add to final schedule
                        return; // Found an alternative, exit the function
                    }
                }
            }
        }

        error_log("No valid alternative found for course ID: {$course['id']}");
    }



    private function getFilteredRooms($course)
    {
        return array_filter($this->rooms, function ($room) use ($course) {
            $kelas = M_kelas::find($course['kelas_id']);
                
                
                // $subject = ;
            $numberParticipant = M_mata_kuliah::find($kelas->matkul_id)->jumlah;

            // Check if the room is general or if it matches the course's major
            $isGeneralRoom = strtolower($room['tipe_ruangan'])  === 'umum';
            $matchesMajor = $room['jurusan_id'] === $course['jurusan_id'];

            return ($isGeneralRoom || $matchesMajor) &&
                $room['kapasitas'] >= $numberParticipant;
        });
    }

    private function calculateEndTime($timeSlot, $sks)
    {
        $startTime = new \DateTime($timeSlot);
        $endTime = clone $startTime;
        $addMinute = $sks * 50;
        $endTime->modify("+{$addMinute} minutes");
        return $endTime->format('H:i:s');
    }

    private function evolvePopulation($population, $fitnessValues)
    {
        $newPopulation = array_slice($population, 0, $this->eliteCount);

        while (count($newPopulation) < $this->populationSize) {
            $parent1 = $this->selectParent($population, $fitnessValues);
            $parent2 = $this->selectParent($population, $fitnessValues);

            // Check if crossover should occur based on the crossover rate
            if (mt_rand() / mt_getrandmax() < $this->crossoverRate) {
                $child = $this->crossover($parent1, $parent2);
            } else {
                // If no crossover, clone one of the parents
                $child = $parent1; // You can also randomly choose between parent1 and parent2
            }

            $child = $this->mutate($child);
            $newPopulation[] = $child;
        }

        return $newPopulation;
    }

    private function selectParent($population, $fitnessValues)
    {
        $totalFitness = array_sum($fitnessValues);
        $rand = mt_rand(0, $totalFitness);

        foreach ($population as $index => $individual) {
            $fitness = $fitnessValues[$index];
            if ($rand <= $fitness) {
                return $individual;
            }
            $rand -= $fitness;
        }
    }

    private function crossover($parent1, $parent2)
    {
        $splitPoint = rand(1, count($parent1) - 1);
        return array_merge(array_slice($parent1, 0, $splitPoint), array_slice($parent2, $splitPoint));
    }

    private function mutate($schedule)
    {
        foreach ($schedule as &$course) {
            if (mt_rand(0, 100) / 100 < $this->mutationRate) {
                $course['hari'] = $this->daysInWeek[array_rand($this->daysInWeek)];
                $course['waktu_mulai'] = $this->timeSlots[array_rand($this->timeSlots)];
                $kelas = M_kelas::find($course['kelas_id']);                                                        
                                                            
                $course['waktu_selesai'] = $this->calculateEndTime($course['waktu_mulai'], M_mata_kuliah::find($kelas->matkul_id)->sks);

                $filteredRooms = $this->getFilteredRooms($course);
                $course['ruangan_id'] = !empty($filteredRooms) ? $filteredRooms[array_rand($filteredRooms)]['id'] : null;

                if (is_null($course['ruangan_id'])) {
                    error_log("No matching room for course ID: {$course['id']}, defaulting to random room.");
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
        return array_map([$this, 'calculateFitness'], $population);
    }

    private function calculateFitness($schedule)
    {
        $totalCourses = count($schedule);
        $calculateOverlap = $this->calculateOverlap($schedule);

        $overlapCount = $calculateOverlap['overlap_count'];

        // If there are no overlaps, return 1 (best fitness)
        if ($overlapCount === 0) {
            return 1;
        }


        $maxPossibleOverlaps = $totalCourses; // In the worst case, each course overlaps with every other
        $fitnessScore = ($maxPossibleOverlaps - $overlapCount) / $maxPossibleOverlaps;

        return max(0, $fitnessScore); // Ensure fitness does not go below 0
    }

    private function timesOverlap($start1, $end1, $start2, $end2)
    {
        // Convert time strings to DateTime objects
        $startTime1 = new \DateTime($start1);
        $endTime1 = new \DateTime($end1);
        $startTime2 = new \DateTime($start2);
        $endTime2 = new \DateTime($end2);

        // Check if one interval overlaps with the other
        return $startTime1 < $endTime2 && $startTime2 < $endTime1;
    }

    private function calculateOverlap($schedule)
    {
        $overlapCount = 0;
        $scheduleOverlap = [];

        // To keep track of room and instructor usage based on day
        $usedRooms = [];
        $usedInstructors = [];

        foreach ($schedule as $course) {
            $day = $course['hari'];
            $room = $course['ruangan_id'];
            $startTime = $course['waktu_mulai'];
            $endTime = $course['waktu_selesai'];

            // ---- Check Room Overlaps ----
            if (!isset($usedRooms[$day])) {
                $usedRooms[$day] = [];
            }
            if (!isset($usedRooms[$day][$room])) {
                $usedRooms[$day][$room] = [];
            }

            // Check if any existing course in this room overlaps with the new course
            foreach ($usedRooms[$day][$room] as $existingCourse) {
                if ($this->timesOverlap($startTime, $endTime, $existingCourse['waktu_mulai'], $existingCourse['waktu_selesai'])) {
                    $overlapCount++;  // Increase overlap count if conflict is found
                    break;  // Exit as soon as one conflict is found for this course
                }
            }

            // Add the current course to the used room slots for further checks
            $usedRooms[$day][$room][] = $course;

            // ---- Check Instructor Overlaps ----
            foreach ($course['dosen'] as $dosen) {
                $instructorId = $dosen['dosen_id'];

                if (!isset($usedInstructors[$day])) {
                    $usedInstructors[$day] = [];
                }
                if (!isset($usedInstructors[$day][$instructorId])) {
                    $usedInstructors[$day][$instructorId] = [];
                }

                // Check if any existing course for this instructor overlaps with the new course
                foreach ($usedInstructors[$day][$instructorId] as $existingCourse) {
                    if ($this->timesOverlap($startTime, $endTime, $existingCourse['waktu_mulai'], $existingCourse['waktu_selesai'])) {
                        $overlapCount++;  // Increase overlap count if conflict is found
                        $scheduleOverlap[] = $course;
                        break;  // Exit as soon as one conflict is found for this course
                    }
                }

                // Add the current course to the used instructor slots for further checks
                $usedInstructors[$day][$instructorId][] = $course;
            }
        }

        return ["overlap_count" => $overlapCount, "overlap_schedule" => $scheduleOverlap];
    }
}
