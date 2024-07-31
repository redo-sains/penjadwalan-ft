<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class M_kurikulum extends Model
{
    use HasFactory;
    protected $table = 'kurikulum';
    protected $fillable = ['tahun_mulai',  'tahun_selesai', 'semester'];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
