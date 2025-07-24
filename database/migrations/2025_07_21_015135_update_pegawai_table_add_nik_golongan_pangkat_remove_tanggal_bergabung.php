<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Metode ini akan dijalankan saat Anda melakukan 'php artisan migrate'.
     */
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            // Hapus kolom tanggal_bergabung (jika belum dihapus)
            if (Schema::hasColumn('pegawai', 'tanggal_bergabung')) {
                $table->dropColumn('tanggal_bergabung');
            }

            // Tambahkan kolom NIK (Nomor Induk Kependudukan)
            // NIK biasanya 16 digit dan unik untuk setiap individu
            $table->string('nik', 16)->unique()->nullable()->after('nomor_telepon'); // Ditambahkan nullable karena data lama mungkin kosong
            
            // Tambahkan kolom golongan_pangkat
            $table->string('golongan_pangkat')->nullable()->after('jabatan'); // Contoh: III/a, Penata Muda, dst.
        });
    }

    /**
     * Reverse the migrations.
     * Metode ini akan dijalankan saat Anda melakukan 'php artisan migrate:rollback'.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            // Untuk rollback, kembalikan kolom tanggal_bergabung
            $table->date('tanggal_bergabung')->nullable()->after('status_pegawai'); // Sesuaikan posisi

            // Hapus kolom NIK saat rollback
            if (Schema::hasColumn('pegawai', 'nik')) {
                $table->dropUnique(['nik']); // Hapus unique constraint dulu sebelum drop kolom
                $table->dropColumn('nik');
            }
            
            // Hapus kolom golongan_pangkat saat rollback
            if (Schema::hasColumn('pegawai', 'golongan_pangkat')) {
                $table->dropColumn('golongan_pangkat');
            }
        });
    }
};