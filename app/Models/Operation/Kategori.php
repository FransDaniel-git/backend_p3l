<?php

namespace App\Models\Operation;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Barang;
use App\Models\Inventory\Barang_Donasi;
use App\Models\Operation\Subkategori;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'id_kategori',
        'nama_kategori',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }

    public function barangdonasi()
    {
        return $this->hasMany(Barang_Donasi::class, 'id_kategori', 'id_kategori');
    }

    public function subkategori()
    {
        return $this->hasMany(Subkategori::class, 'id_kategori', 'id_kategori');
    }
}
