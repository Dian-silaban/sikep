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
        Schema::create('pendidikans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pendidikan')->unique(); // Contoh: SD, SMP, SMA, D-I, S-1, S-2
            $table->string('jenjang')->nullable(); // Contoh: Dasar, Menengah, Diploma, Sarjana (opsional)
            $table->integer('urutan')->nullable(); // Untuk pengurutan di dropdown atau laporan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikans');
    }
};
