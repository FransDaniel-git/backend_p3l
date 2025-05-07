<?php

namespace App\Models\Operation;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Barang;
use App\Models\Inventory\Barang_Donasi;

class Subkategori extends Model
{
    protected $table = 'subkategoris';

    protected $fillable = [
        'id_subkategori',
        'id_kategori',
        'nama_subkategori',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_subkategori', 'id_subkategori');
    }
    public function barang_donasi()
    {
        return $this->hasMany(Barang_Donasi::class, 'id_subkategori', 'id_subkategori');
    }
}
