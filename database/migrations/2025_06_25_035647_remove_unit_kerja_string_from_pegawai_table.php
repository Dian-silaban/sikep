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
        $table->dropColumn('unit_kerja'); // kolom lama yang tidak dipakai
    });
}

public function down(): void
{
    Schema::table('pegawai', function (Blueprint $table) {
        $table->string('unit_kerja')->nullable();
    });
}

};
