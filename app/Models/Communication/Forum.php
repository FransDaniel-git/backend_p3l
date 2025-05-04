<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_forum',
        'kode_barang',
        'judul',
        'deskripsi',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function pertanyaan(){
        return $this->hasMany(Pertanyaan::class,'id_forum','id_forum');
    }

    public function  jawaban(){
        return $this->hasMany(Jawaban::class,'id_forum','id_forum');
    }

    public function barang(){
        return $this->belongsTo(Barang::class,'kode_barang','kode_barang');
    }
}
