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
        Schema::table('pegawai', function (Blueprint $table) {
            // Tambahkan kolom 'tmt_status' sebagai tanggal, bisa null
            // Ini adalah TMT untuk status pegawai yang sedang aktif
            $table->date('tmt_status')->nullable()->after('status_pegawai'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            // Hapus kolom 'tmt_status' saat rollback
            $table->dropColumn('tmt_status');
        });
    }
    
};
