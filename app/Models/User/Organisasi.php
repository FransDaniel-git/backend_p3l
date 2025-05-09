<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction\Permohonan;

class Organisasi extends Model
{
    protected $table = 'organisasis';
    protected $primaryKey = 'id_organisasi'; // Add this line
    public $incrementing = false; // Set to false if using string IDs like 'T1'
    protected $keyType = 'string'; // Set to 'string' if your ID is not numeric

    protected $fillable = [
        'id_organisasi',
        'nama',
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
