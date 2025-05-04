<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->foreignId('id_jadwal')->constrained('jadwals','id_jadwal')->onDelete('cascade');
            $table->foreignId('no_penjualan')->constrained('penjualans','no_penjualan')->onDelete('cascade');
            $table->string('id_pegawai');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawais')->onDelete('cascade');
            $table->string('status')->default('Belum Siap Dikirim');
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimen');
    }
};
