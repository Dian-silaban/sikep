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
        Schema::table('pegawai', function (Blueprint $table) {
            // Tambahkan foreign key baru untuk golongan, eselon, dan pendidikan
            // Pastikan kolom ini nullable jika ada data lama yang mungkin tidak punya padanan langsung
            $table->foreignId('golongan_id')->nullable()->after('nik')->constrained('golongans')->onDelete('set null');
            $table->foreignId('eselon_id')->nullable()->after('jabatan')->constrained('eselons')->onDelete('set null');
            $table->foreignId('pendidikan_id')->nullable()->after('eselon_id')->constrained('pendidikans')->onDelete('set null');

            // Hapus kolom lama yang tidak lagi digunakan sebagai string
            // HATI-HATI: Jika ada data di kolom lama, Anda perlu memigrasikannya terlebih dahulu
            // sebelum menghapus kolom ini. Untuk saat ini, kita akan langsung menghapus.
            if (Schema::hasColumn('pegawai', 'golongan_pangkat')) {
                $table->dropColumn('golongan_pangkat');
            }
            // Kolom 'jabatan' tetap ada sebagai string, jadi tidak di-drop.
            // Hapus kolom 'tipe_jabatan' jika ada dari percobaan sebelumnya
            if (Schema::hasColumn('pegawai', 'tipe_jabatan')) {
                $table->dropColumn('tipe_jabatan');
            }
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            // Hapus foreign key saat rollback
            $table->dropConstrainedForeignId('golongan_id');
            $table->dropConstrainedForeignId('eselon_id');
            $table->dropConstrainedForeignId('pendidikan_id');

            // Tambahkan kembali kolom lama jika rollback
            $table->string('golongan_pangkat')->nullable();
            $table->string('tipe_jabatan')->nullable(); // Tambahkan kembali jika sebelumnya ada
        });
    }
};
