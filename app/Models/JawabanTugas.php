<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTugas extends Model
{
    use HasFactory;
    protected $fillable = ['id','id_tugas','isi_jawaban','create_at','update_at'];
    public $timestamps = true;

    public function tugas(){
        return $this->belongsTo(Tugas::class, 'id_tugas');
    }
}
