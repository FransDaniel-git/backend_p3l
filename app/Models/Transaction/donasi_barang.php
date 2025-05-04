<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class donasi_barang extends Model
{
    protected $table = 'donasi_barangs';

    protected $fillable = [
        'id_donasi_barang',
        'id_barang_donasi',
        'id_donasi'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function barangdonasi()
    {
        return $this->belongsTo(Barang_Donasi::class, 'id_barang_donasi', 'id_barang_donasi');
    }

    public function donasi()
    {
        return $this->belongsTo(Donasi::class, 'id_donasi', 'id_donasi');
    }
}
