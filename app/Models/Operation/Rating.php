<?php

namespace App\Models\Operation;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Barang;
use App\Models\User\Penitip;
use App\Models\User\Pelanggan;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'id',
        'id_penitip',
        'kode_barang',
        'id_pelanggan',
        'value',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function penitip(){
        return $this->belongsTo(Penitip::class, 'id_penitip', 'id_penitip');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    
}
