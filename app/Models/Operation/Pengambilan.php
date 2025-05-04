<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengambilan extends Model
{
    protected $table = 'pengambilan';

    protected $fillable = [
        'id_pengambilan',
        'id_jadwal',
        'no_penjualan',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function jadwal(){
        return $this->belongsTo(Jadwal::class,'id_jadwal','id_jadwal');
    }

    public function penjualan(){
        return $this->belongsTo(Penjualan::class,'no_penjualan','no_penjualan');
    }
}
