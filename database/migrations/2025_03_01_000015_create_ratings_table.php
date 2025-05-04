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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('id_penitip');
            $table->string('id_pelanggan');

            $table->integer('value');
            $table->timestamps();

            $table->foreign('kode_barang')->references('kode_barang')->on('barangs')->onDelete('cascade');

            $table->foreign('id_penitip')->references('id_penitip')->on('penitips')->onDelete('cascade');

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
