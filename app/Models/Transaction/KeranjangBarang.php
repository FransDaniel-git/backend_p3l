<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangBarang extends Model
{
    protected $table = 'keranjang_barangs';

    protected $fillable = [
        'id_keranjang_barang',
        'id_keranjang',
        'kode_barang',
        'jumlah',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function keranjang(){
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }
}
