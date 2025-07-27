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
        Schema::create('bezetting_kontrak_data', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel unit_kerja
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerja')->onDelete('set null');
            // Foreign key ke tabel pendidikans
            $table->foreignId('pendidikan_id')->nullable()->constrained('pendidikans')->onDelete('set null');
            
            // eselon_category akan menyimpan kategori eselon yang sesuai dengan kolom laporan bezetting
            // Contoh: 'I', 'II', 'III', 'IV', 'JFU'
            $table->string('eselon_category'); 
            $table->string('golongan_category')->default('KONTRAK'); // Akan selalu 'KONTRAK' untuk baris ini
            $table->integer('jumlah_pegawai');
            $table->unsignedTinyInteger('bulan'); // Bulan (1-12)
            $table->year('tahun'); // Tahun
            $table->timestamps();

            // Menambahkan unique constraint untuk mencegah duplikasi entri per unit, pendidikan, eselon, bulan, tahun
            $table->unique(['unit_kerja_id', 'pendidikan_id', 'eselon_category', 'bulan', 'tahun'], 'bezetting_kontrak_unique');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('bezetting_kontrak_data');
    }
};
