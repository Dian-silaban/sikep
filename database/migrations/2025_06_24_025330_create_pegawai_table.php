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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable(); // Laki-laki, Perempuan
            $table->text('alamat')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('status_pegawai')->nullable(); // Aktif, Non-aktif, Pensiun
            $table->date('tanggal_bergabung')->nullable();
            $table->string('foto_profil_path')->nullable(); // Path ke file foto profil
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
