<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang_Donasi extends Model
{
    protected $table = 'barang_donasis';

    protected $fillable = [
        'id_barang_donasi',
        'id_subkategori',
        'id_penitip',
        'gambar',
        'nama',
        'ukuran',
        'deskripsi',
        'berat',
        'status_donasi',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class, 'id_subkategori', 'id_subkategori');
    }

    public function donasibarang()
    {
        return $this->hasMany(donasi_barang::class, 'id_barang_donasi', 'id_barang_donasi');
    }
}
