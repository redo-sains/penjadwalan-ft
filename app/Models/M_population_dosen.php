<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_population_dosen extends Model
{
    use HasFactory;
    protected $table = 'population_dosen';
    protected $primaryKey = 'id';
    protected $fillable = ['population_id', 'dosen_id'];
    public $timestamps = false;
    
    // Relasi dengan tabel dosen
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(M_dosen::class, 'dosen_id');
    }

    public function population(): BelongsTo
    {
        return $this->belongsTo(M_Populations::class, 'population_id');
    }
    
}
