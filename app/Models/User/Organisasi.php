<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction\Permohonan;

class Organisasi extends Model
{
    protected $table = 'organisasis';

    protected $fillable = [
        'id_organisasi',
        'nama',
        'nama_penerima',
        'email',
        'alamat',
        'verified',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function permohonan(){
        return $this->hasMany(Permohonan::class, 'id_organisasi', 'id_organisasi');
    }
}
