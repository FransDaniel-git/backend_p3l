<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    protected $table = 'komisis';
    protected $fillable = [
        'id_komisi',
        'id_pegawai',
        'no_penjualan',
        'kode_barang',
        'komisi',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class,'id_pegawai','id_pegawai');
    }

    public function penjualan(){
        return $this->belongsTo(Penjualan::class,'no_penjualan','no_penjualan');
    }

    public function barang(){
        return $this->belongsTo(Barang::class,'kode_barang','kode_barang');
    }
}
