<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['nama_unit' => 'Aset', 'deskripsi' => 'Divisi Aset Daerah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'Bidang Anggaran & Perbendaharaan', 'deskripsi' => 'Bidang Pengelolaan Anggaran dan Perbendaharaan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'Bidang Akuntansi', 'deskripsi' => 'Bidang Akuntansi Keuangan Daerah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'UPT Kasda', 'deskripsi' => 'Unit Pelaksana Teknis Kas Daerah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'UPT Pemanfaatan Aset Daerah', 'deskripsi' => 'Unit Pelaksana Teknis Pemanfaatan Aset Daerah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_unit' => 'Sekretariat', 'deskripsi' => 'Sekretariat Instansi', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($units as $unit) {
            DB::table('unit_kerja')->updateOrInsert(
                ['nama_unit' => $unit['nama_unit']],
                $unit
            );
        }
    }
}