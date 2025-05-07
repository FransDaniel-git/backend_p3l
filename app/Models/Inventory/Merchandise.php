<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction\Klaim;

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
