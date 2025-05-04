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
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->foreignId('id_pertanyaan')->constrained('pertanyaans','id_pertanyaan')->onDelete('cascade');
            $table->string('id_pegawai');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawais')->onDelete('cascade');
            $table->string('text_jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
