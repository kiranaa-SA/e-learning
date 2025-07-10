<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = ['id','kode_quiz','judul','jumlah_soal','waktu_pengerjaan','tenggat_waktu','create_at','update_at'];
    public $timestamps = true;

}
