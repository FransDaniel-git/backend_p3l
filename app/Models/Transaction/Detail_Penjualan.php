<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_Penjualan extends Model
{
    protected $table = 'detail__penjualans';

    protected $fillable = [
        'id_detail_penjualan',
        'id_penjualan',
        'kode_barang',
        'komisi',
        'bonus',
        'total_transaksi',
        'total_penitip',
        'total_reusemart',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function penjualan(){
        return $this->belongsTo(Penjualan::class,'id_penjualan','id_penjualan');
    }
}
