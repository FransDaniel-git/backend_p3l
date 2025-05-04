<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Penitipan extends Model
{
    protected $table = 'penitipans';

    protected $fillable = [
        'id_penitipan',
        'list_barang',
        'id_penitip',
        'id_pegawai'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_penitipan', 'id_penitipan');
    }
    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip', 'id_penitip');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}
