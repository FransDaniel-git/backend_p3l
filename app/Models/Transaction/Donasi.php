<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasis';
    protected $primaryKey = 'id_donasi';
    public $incrementing = true;

    protected $fillable = [
        'id_donasi',
        'id_permohonan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id_permohonan');
    }

    public function donasiBarang()
    {
        return $this->hasMany(Donasi_Barang::class, 'id_donasi', 'id_donasi');
    }

}
