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
            // Tanggal acuan awal untuk perhitungan usulan kenaikan gaji berkala (KGB)
            $table->date('tgl_usulan_berkala_awal')->nullable()->after('tmt_status');
            // Tanggal acuan awal untuk perhitungan usulan kenaikan pangkat (KP)
            $table->date('tgl_usulan_kp_awal')->nullable()->after('tgl_usulan_berkala_awal');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn('tgl_usulan_berkala_awal');
            $table->dropColumn('tgl_usulan_kp_awal');
        });
    }
};
