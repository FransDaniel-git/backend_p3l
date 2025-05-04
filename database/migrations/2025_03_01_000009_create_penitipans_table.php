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
        Schema::create('penitipans', function (Blueprint $table) {
            $table->string('id_penitipan')->primary();
            $table->string('list_barang');
            $table->string('id_penitip');
            $table->string('id_pegawai');
            $table->timestamps();

            $table->foreign('id_penitip')->references('id_penitip')->on('penitips')->onDelete('cascade');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawais')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penitipans');
    }
};
