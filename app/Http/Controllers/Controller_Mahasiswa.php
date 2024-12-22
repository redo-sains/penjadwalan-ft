<?php

namespace App\Http\Controllers;

use App\Models\M_dosen;
use App\Models\M_jurusan;
use App\Models\M_kelas;
use App\Models\M_kurikulum;
use App\Models\M_mata_kuliah;
use App\Models\M_Populations;
use App\Models\M_ruangan;
use Illuminate\Http\Request;

class Controller_Mahasiswa extends Controller
{
    //
    public function show(Request $request)
    {
        $title = 'Dashboard Mahasiswa';
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

            return view('mahasiswa.dashboard.index', compact("hari_id" ,"jurusan_id",'last_id','populations', 'title', 'jurusans', 'dosens', 'matkuls', 'ruangans', 'kurikulums', 'id'));
        }
        
        $id = M_kurikulum::all()->last()->id;        

        $route_name = $request->route()->getName();
        

        return redirect()->route($route_name, ["kurikulum_id" => $last_id]);
        // return view('mahasiswa.Dashboard.index', compact('title', 'dosens', 'jurusans', 'matakuliahs'));
    }
}
