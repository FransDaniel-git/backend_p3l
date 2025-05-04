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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('id_pegawai')->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('id_jabatan')->constrained('jabatans', 'id_jabatan')->onDelete('cascade');

            
            $table->date('tanggal_lahir');
            $table->string('noTelp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
