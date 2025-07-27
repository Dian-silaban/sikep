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
        Schema::table('dokumen_pegawai', function (Blueprint $table) {
            // Tambahkan kolom 'tmt_dokumen' sebagai tanggal, bisa null
            // Ini adalah TMT (Tanggal Mulai Terhitung) dokumen
            $table->date('tmt_dokumen')->nullable()->after('tanggal_upload'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen_pegawai', function (Blueprint $table) {
            // Hapus kolom 'tmt_dokumen' saat rollback
            $table->dropColumn('tmt_dokumen');
        });
    }
};
