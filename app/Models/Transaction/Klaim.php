<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
