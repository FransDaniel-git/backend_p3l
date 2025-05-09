<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Operation\Rating;
use App\Models\Transaction\Penitipan;


class Penitip extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'penitips';
    protected $primaryKey = 'id_penitip'; // Add this line
    public $incrementing = false; // Set to false if using string IDs like 'T1'
    protected $keyType = 'string'; // Set to 'string' if your ID is not numeric

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

    public function barangDonasis()
    {
        return $this->hasMany(\App\Models\Inventory\Barang_Donasi::class, 'id_penitip', 'id_penitip');
    }
}
