<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'id_penitipan',
        'id_subkategori',
        'nama',
        'ukuran',
        'deskripsi',
        'hunter',
        'berat',
        'kondisi',
        'masa_penitipan',
        'perpanjangan',
        'harga',
        'tanggal_garansi',
        'status',
        'gambar',
        'tanggal_laku'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function penitipan(){
        return $this->belongsTo(Penitipan::class, 'id_penitipan', 'id_penitipan');
    }

    public function keranjangBarang(){
        return $this->hasMany(KeranjangBarang::class, 'kode_barang', 'kode_barang');
    }

    public function forum(){
        return $this->hasOne(Forum::class, 'kode_barang', 'kode_barang');
    }

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class, 'id_subkategori', 'id_subkategori');
    }
}
