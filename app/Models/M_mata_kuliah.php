<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_mata_kuliah extends Model
{
    use HasFactory;
        protected $table = 'mata_kuliah';
        protected $primaryKey = 'id';
        public $timestamps = true;
        protected $fillable = [
            'nama', 'kode', 'semester', 'jurusan_id', 'sks'
        ];
}
