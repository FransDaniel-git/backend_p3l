<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Organisasi;

class Permohonan extends Model
{
    protected $table = 'permohonans';
    protected $primaryKey = 'id_permohonan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_permohonan',
        'id_organisasi',
        'nama_penerima',
        'catatan',
        'status_permohonan',
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
