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
        Schema::create('alamats', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->string('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id_pelanggan',)->on('pelanggans')->onDelete('cascade');
            $table->string('detail_alamat');
            $table->boolean('default')->default(0);
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamats');
    }
};
