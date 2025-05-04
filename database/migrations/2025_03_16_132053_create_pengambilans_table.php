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
        Schema::create('pengambilans', function (Blueprint $table) {
            $table->id('id_pengambilan');
            $table->foreignId('id_jadwal')->constrained('jadwals','id_jadwal')->onDelete('cascade');
            $table->foreignId('no_penjualan')->constrained('penjualans','no_penjualan')->onDelete('cascade');
            $table->string('status')->default('Belum Siap Ambil');
            $table->timestamps();     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengambilans');
    }
};
