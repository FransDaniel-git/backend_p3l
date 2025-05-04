<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penitip extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'penitips';

    protected $fillable = [
        'id_penitip',
        'nama',
        'nomer_induk_penduduk',
        'foto_ktp',
        'email',
        'password',
        'poin',
        'saldo',
        'rating_total',
        'barang_terjual',
        'tanggal_lahir',
        'verified',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function rating(){
        return $this->hasMany(Rating::class, 'id_penitip', 'id_penitip');
    }

    public function penitipan(){
        return $this->hasMany(Penitipan::class, 'id_penitip', 'id_penitip');
    }
}
