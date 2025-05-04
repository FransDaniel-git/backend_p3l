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
        Schema::create('detail__penjualans', function (Blueprint $table) {
            $table->id('id_detail_penjualan');
            $table->foreignId('no_penjualan')->constrained('penjualans','no_penjualan')->onDelete('cascade');
            $table->string('kode_barang');
            $table->foreign('kode_barang')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->double('bonus');
            $table->double('komisi');
            $table->double('total_transaksi');
            $table->double('total_penitip');
            $table->double('total_reusemart');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail__penjualans');
    }
};
