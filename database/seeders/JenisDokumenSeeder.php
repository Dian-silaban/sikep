<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisDokumen = [
            ['nama_jenis' => 'KTP', 'deskripsi' => 'Kartu Tanda Penduduk', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Ijazah', 'deskripsi' => 'Ijazah Pendidikan Terakhir', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Sertifikat Pelatihan', 'deskripsi' => 'Sertifikat keikutsertaan pelatihan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'SK Pengangkatan', 'deskripsi' => 'Surat Keputusan Pengangkatan Jabatan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'SK Kenaikan Pangkat', 'deskripsi' => 'Surat Keputusan Kenaikan Pangkat', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Kartu Keluarga', 'deskripsi' => 'Kartu Keluarga', 'created_at' => now(), 'updated_at' => now()],
            // Tambahkan jenis dokumen lain sesuai kebutuhan
        ];

        // Memasukkan data hanya jika nama_jenis belum ada
        foreach ($jenisDokumen as $jenis) {
            DB::table('jenis_dokumen')->updateOrInsert(
                ['nama_jenis' => $jenis['nama_jenis']], // Kondisi untuk mencari
                $jenis // Data yang akan di-insert atau update
            );
        }
    }
}