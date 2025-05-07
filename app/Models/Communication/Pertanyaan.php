<?php

namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Pelanggan;
use App\Models\User\Pegawai;

class Pertanyaan extends Model
{
    protected $fillable = [
        'id_pertanyaan',
        'id_pelanggan',
        'id_forum',
        'text_pertanyaan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function forum(){
        return $this->belongsTo(Forum::class,'id_forum','id');
    }

    public function jawaban(){
        return $this->hasMany(Jawaban::class,'id_pertanyaan','id');
    }

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class,'id_pelanggan','id_pelanggan');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'id_pegawai','id_pegawai');
    }
}
