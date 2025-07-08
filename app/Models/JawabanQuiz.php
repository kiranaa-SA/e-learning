<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanQuiz extends Model
{
    use HasFactory;
    protected $fillable = ['id','id_quiz','isi_jawaban','create_at','update_at'];
    public $timestamps = true;

    public function quiz(){
        return $this->belongsTo(Quiz::class, 'id_quiz');
    }

}
