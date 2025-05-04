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
        Schema::create('forums', function (Blueprint $table) {
            $table->id('id_forum');
            $table->string('kode_barang');  
            $table->string('judul');
            $table->string('deskripsi');
            $table->timestamps();

            $table->foreign('kode_barang')->references('kode_barang')->on('barangs')->onDelete('cascade');

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forums');
    }
};
