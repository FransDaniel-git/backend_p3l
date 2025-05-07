<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
//organisasi
use App\Models\User\Organisasi;

class Permohonan extends Model
{
    protected $table = 'permohonan';

    protected $fillable = [
        'id-permohonan',
        'id_organisasi',
        'catatan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function penerima(){
        return $this->belongsTo(Organisasi::class, 'id_organisasi', 'id_organisasi');
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_permohonan', 'id_permohonan');
    }

}
