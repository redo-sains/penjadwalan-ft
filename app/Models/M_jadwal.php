<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal_kuliah';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'mata_kuliah_id', 'dosen_id', 'ruangan_id', 'hari', 'waktu_mulai', 'waktu_selesai'
    ];
}
