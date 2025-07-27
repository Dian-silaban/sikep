<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('eselons', function (Blueprint $table) {
            $table->id();
            // nama_eselon akan langsung menjadi kategori yang digunakan di laporan bezetting
            // Contoh: 'I', 'II', 'III', 'IV', 'JFU'
            $table->string('nama_eselon')->unique();
            $table->integer('urutan')->nullable(); // Untuk pengurutan di dropdown
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('eselons');
    }
};
