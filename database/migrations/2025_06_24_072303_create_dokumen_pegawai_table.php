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
        Schema::create('dokumen_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->foreignId('jenis_dokumen_id')->constrained('jenis_dokumen')->onDelete('cascade');
            $table->string('nama_file_asli');
            $table->string('nama_file_tersimpan'); // Nama unik di server/cloud storage
            $table->string('path_file'); // Lokasi penyimpanan file
            $table->dateTime('tanggal_upload');
            $table->unsignedInteger('versi_dokumen')->default(1); // Default versi 1
            $table->string('status_dokumen')->default('Aktif'); // Aktif, Kadaluarsa, Revisi, Dihapus
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Optional: Ensure combination of pegawai_id, jenis_dokumen_id, and versi_dokumen is unique
            // $table->unique(['pegawai_id', 'jenis_dokumen_id', 'versi_dokumen']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pegawai');
    }
};