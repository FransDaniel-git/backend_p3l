<?php

namespace App\Models\User;

use App\Models\Communication\Pertanyaan;
use App\Models\Transaction\Keranjang;
use App\Models\Inventory\Jabatan;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction\Penjualan;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Pelanggan extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'pelanggans';
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = false; // Jika primary key tidak auto increment
    protected $keyType = 'string'; // Jika primary key bukan integer
    protected $fillable = [
        'id_pelanggan',
        'nama',
        'email',
        'verified',
        'id_jabatan',
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

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }
}
