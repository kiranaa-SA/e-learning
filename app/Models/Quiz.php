<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = ['id','kode_quiz','judul','soal_quiz','waktu_pengerjaaan','tenggat_waktu','create_at','update_at'];
    public $timestamps = true;

}
