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
        Schema::create('klaims', function (Blueprint $table) {
            $table->id('id_klaim');
            $table->string('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
            $table->foreignId('id_merchandise')->constrained('merchandises','id_merchandise')->onDelete('cascade');
            $table->double('total_poin');
            $table->boolean('status_klaim')->default(0);
            $table->date('tanggal_klaim')->nullable();
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klaims');
    }
};
