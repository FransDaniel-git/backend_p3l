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
        Schema::create('komisis', function (Blueprint $table) {
            $table->id('id_komisi');
            $table->string('id_pegawai');
            $table->foreignId('no_penjualan')->constrained('penjualans','no_penjualan')->onDelete('cascade');
            $table->string('kode_barang');
            $table->double('komisi');
            $table->double('komisi_reusemart');      
            $table->double('bonus');
            $table->timestamps();

            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawais')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komisis');
    }
};
