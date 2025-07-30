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
        Schema::create('riwayat_jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->string('nama_jabatan'); // Nama jabatan (string)
            $table->foreignId('eselon_id')->constrained('eselons')->onDelete('cascade'); // FK ke tabel eselons
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerja')->onDelete('set null'); // FK ke tabel unit_kerja
            $table->date('tmt_jabatan'); // Tanggal Mulai Terhitung jabatan ini
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatans');
    }
};
