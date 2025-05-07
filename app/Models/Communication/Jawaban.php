<?php

namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Pegawai;

class Jawaban extends Model
{
    protected $fillable = [
        'id_jawaban',
        'id_pegawai',
        'id_pertanyaan',
        'text_jawaban',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    

    public function pertanyaan(){
        return $this->belongsTo(Pertanyaan::class,'id_pertanyaan','id');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'id_pegawai','id_pegawai');
    }
}
