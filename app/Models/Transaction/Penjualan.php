<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Pelanggan;
use App\Models\User\Penitip;
//komisi
use App\Models\Inventory\Komisi;
//pengambilan
use App\Models\Operation\Pengambilan;
//pengiriman
use App\Models\Operation\Pengiriman;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'no_penjualan',
        'no_nota',
        'total',
        'list_barang',
        'bukti_transfer',
        'alamat',
        'status',
        'tipe',
        'id_pelanggan',
        'id_penitip',
        'tanggal_lunas'
        
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function penitip(){
        return $this->belongsTo(Penitip::class, 'id_penitip', 'id_penitip');
    }

    public function komisi(){
        return $this->hasMany(Komisi::class, 'no_penjualan', 'no_penjualan');
    }

    public function detailPenjualan(){
        return $this->hasOne(Detail_Penjualan::class, 'no_penjualan', 'no_penjualan');
    }

    public function pengambilan(){
        return $this->hasOne(Pengambilan::class, 'no_penjualan', 'no_penjualan');
    }

    public function pengiriman(){
        return $this->hasOne(Pengiriman::class, 'no_penjualan', 'no_penjualan');
    }
}
