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
        Schema::create('barangs', function (Blueprint $table) {
            $table->string('kode_barang')->primary();
            $table->string('id_penitipan');
            $table->foreignId('id_subkategori')->constrained('subkategoris','id_subkategori')->onDelete('cascade');
            $table->string('nama');
            $table->string('ukuran');
            $table->text(column: 'deskripsi');
            $table->string('hunter');
            $table->string('gambar');
            $table->double('berat');
            $table->string('kondisi');
            $table->date('tanggal_garansi')->nullable();
            $table->integer('masa_penitipan');
            $table->boolean('perpanjangan')->default(0);
            $table->double('harga'); 
            $table->string('status')->default('Tersedia');
            $table->date('tanggal_laku')->nullable();
            $table->timestamps();
            
            $table->foreign('id_penitipan')->references('id_penitipan')->on('penitipans')->onDelete('cascade');
            
        });


        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
