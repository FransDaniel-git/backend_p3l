<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    protected $table = 'merchandises';

    protected $fillable = [
        'id_merchandise',
        'nama',
        'jumlah_poin',
        'gambar',
        'stok',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function klaim()
    {
        return $this->hasMany(Klaim::class, 'id_merchandise', 'id_merchandise');
    }
}
