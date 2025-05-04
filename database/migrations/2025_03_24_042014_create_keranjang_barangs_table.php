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
        Schema::create('keranjang_barangs', function (Blueprint $table) {
            $table->id('id_keranjang_barang');
            $table->foreignId('id_keranjang')->constrained('keranjangs','id_keranjang')->onDelete('cascade');
            $table->string('kode_barang');
            $table->foreign('kode_barang')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_barangs');
    }
};
