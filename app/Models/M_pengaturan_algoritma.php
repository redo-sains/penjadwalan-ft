<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_pengaturan_algoritma extends Model implements Authenticatable
{
    use HasFactory;
    use \Illuminate\Auth\Authenticatable;

    protected $table = 'pengaturan_algoritma';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'umur',
        'waktu',
    ];
}
