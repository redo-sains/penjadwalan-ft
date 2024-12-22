<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $fillable = ['matkul_id', 'jumlah'];
    public $timestamps = false;        

    // Relasi dengan tabel mata kuliah
    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(M_mata_kuliah::class, 'matkul_id');
    }

}
