<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Pelanggan extends Model
{
    use HasApiTokens, HasFactory;
    protected $table = 'Pelanggans';
    protected $fillable = [
        'id_pelanggan',
        'nama',
        'email',
        'verified',
        'tanggal_lahir',
        'noTelp',
        'poin',
        'password',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $cast = [
        'tanggal_lahir' => 'date:d-m-Y',
        'created_at' => 'date:d-m-Y',
        'updated_at' => 'date:d-m-Y',
        'verified_at' => 'date:d-m-Y',
        'poin' => 'integer',
        'verified' => 'boolean',
    ];

    public function penjualan(){
        return $this->hasMany(Penjualan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function pertanyaan(){
        return $this->hasMany(Pertanyaan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function alamat(){
        return $this->hasOne(Alamat::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function keranjang(){
        return $this->hasOne(Keranjang::class, 'id_pelanggan', 'id_pelanggan');
    }
}
