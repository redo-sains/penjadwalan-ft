<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_ketersediaan_ruangan extends Model
{
    use HasFactory;
    protected $table = 'ketersediaan_ruangan';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'ruangan_id', 'hari', 'waktu_mulai', 'waktu_selesai'
    ];
}
