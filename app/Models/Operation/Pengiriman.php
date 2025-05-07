<?php

namespace App\Models\Operation;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction\Penjualan;
use App\Models\User\Pegawai;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';

    protected $fillable = [
        'id_pengiriman',
        'id_jadwal',
        'no_penjualan',
        'id_pegawai',
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

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'id_pegawai','id_pegawai');
    }
}
