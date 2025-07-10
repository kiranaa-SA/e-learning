<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = ['id','kode_quiz','judul','id_mapel','jumlah_soal','waktu_pengerjaan','tenggat_waktu','create_at','update_at'];
    public $timestamps = true;
     public function soal()
    {
        return $this->hasMany(SoalQuiz::class, 'quiz_id');
    }
     public function mapel(){
        return $this->belongsTo(Mapel::class,'id_mapel');
    }

}
