<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Pelanggan;

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
