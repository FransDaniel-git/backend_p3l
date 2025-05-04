<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'id_jadwal',
        'tipe',
        'tanggal',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pengiriman(){
        return $this->hasOne(Pengiriman::class,'id_jadwal','id_jadwal');
    }

    public function pengambilan(){
        return $this->hasOne(Pengambilan::class,'id_jadwal','id_jadwal');
    }
}
