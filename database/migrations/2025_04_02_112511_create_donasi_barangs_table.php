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
        Schema::create('donasi_barangs', function (Blueprint $table) {
            $table->id('id_donasi_barang');
            $table->string('id_barang_donasi');
            $table->foreign('id_barang_donasi')->references('id_barang_donasi')->on('barang_donasis')->onDelete('cascade');
            $table->foreignId('id_donasi')->constrained('donasis','id_donasi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi_barangs');
    }
};
