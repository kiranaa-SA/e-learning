<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    protected $fillable = ['id','kode_tugas','judul','soal_tugas','create_at','update_at'];
    public $timestamps = true;

}
