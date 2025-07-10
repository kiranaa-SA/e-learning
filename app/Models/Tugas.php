<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    protected $fillable = ['id','kode_tugas','judul','id_mapel','jumlah_soal','create_at','update_at'];
    public $timestamps = true;
    public function soal()
    {
        return $this->hasMany(SoalTugas::class, 'id_tugas');
    }
     public function mapel(){
        return $this->belongsTo(Mapel::class,'id_mapel');
    }
}
