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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->string('id_pelanggan')->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('noTelp');
            $table->string('password');
            $table->date('tanggal_lahir');
            $table->integer('poin')->default(0);
            $table->boolean('verified')->default(0);
            $table->date('verified_at')->nullable()->default(null);
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
