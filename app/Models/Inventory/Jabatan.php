<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Pegawai;

class Jabatan extends Model
{
    protected $table = 'jabatans';

    protected $fillable = [
        'id_jabatan',
        'nama_jabatan',
        'izin',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_jabatan', 'id_jabatan');
    }
}
