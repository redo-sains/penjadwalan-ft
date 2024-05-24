<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_ketersediaan_dosen extends Model
{
    use HasFactory;
    protected $table = 'ketersediaan_dosen';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'dosen_id', 'hari', 'waktu_mulai', 'waktu_selesai'
    ];
}
