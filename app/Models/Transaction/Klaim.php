<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Merchandise;
use App\Models\User\Pelanggan;

class Klaim extends Model
{
    protected $table = 'klaim';

    protected $fillable = [
        'id_klaim',
        'id_pelanggan',
        'id_merchandise',
        'total_poin',
        'status_klaim',
        'tanggal_klaim',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function merchandise(){
        return $this->belongsTo(Merchandise::class, 'id_merchandise', 'id_merchandise');
    }

    

    
}
