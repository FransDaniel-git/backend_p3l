<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjangs';

    protected $fillable = [
        'id_keranjang',
        'id_pelanggan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function keranjangBarang(){
        return $this->hasMany(KeranjangBarang::class, 'id_keranjang', 'id_keranjang');
    }
}
