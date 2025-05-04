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
        Schema::create('penitips', function (Blueprint $table) {
            $table->string('id_penitip')->primary();
            $table->string('nama');
            $table->string('nomer_induk_penduduk')->unique();
            $table->string('foto_ktp');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('poin')->default(0);
            $table->double('saldo')->default(0.0);
            $table->double('rating_total')->default(0.0);
            $table->integer('barang_terjual')->default(0);
            $table->date('tanggal_lahir');
            $table->boolean('verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penitips');
    }
};
