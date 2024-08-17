<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class M_Populations extends Model
{
    use HasFactory;
    protected $table = 'populations';
    protected $primaryKey = 'id';
    protected $fillable = ['jurusan_id', 'matkul_id',  'ruangan_id', 'kapasitas', 'hari', 'waktu_mulai', 'waktu_selesai', 'kurikulum_id'];
    public $timestamps;

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(M_jurusan::class, 'jurusan_id');
    }

    // Relasi dengan tabel mata kuliah
    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(M_mata_kuliah::class, 'matkul_id');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(M_ruangan::class, 'ruangan_id');
    }

    public function dosen() : HasMany
    {
        return $this->hasMany(M_population_dosen::class, 'population_id', 'id');
    }
}
