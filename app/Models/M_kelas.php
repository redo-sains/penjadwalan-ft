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
    protected $fillable = ['jurusan_id', 'matkul_id', 'dosen_id', 'kelas', 'kapasitas'];
    public $timestamps = true;

    // Relasi dengan tabel jurusan
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(M_jurusan::class, 'jurusan_id');
    }

    // Relasi dengan tabel mata kuliah
    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(M_mata_kuliah::class, 'matkul_id');
    }

    // Relasi dengan tabel dosen
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(M_dosen::class, 'dosen_id');
    }
}
