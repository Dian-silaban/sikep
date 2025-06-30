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
             
            ['nama_jenis' => 'SK Gaji Berkala', 'deskripsi' => 'Surat Keputusan Gaji Berkala', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'SK CPNS / SK 80%', 'deskripsi' => 'Surat Keputusan Calon Pegawai Negeri Sipil / SK 80%', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'SK PNS / SK 100%', 'deskripsi' => 'Surat Keputusan Pegawai Negeri Sipil / SK 100%', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'SK Pangkat dan Golongan', 'deskripsi' => 'Surat Keputusan Pangkat dan Golongan (II.a – II.d, III.a-III.d, IV.a –IV.d)', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Karpeg/Kartu Pegawai', 'deskripsi' => 'Kartu Pegawai', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Karsu/Karis', 'deskripsi' => 'Kartu Suami/Istri', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'KK', 'deskripsi' => 'Kartu Keluarga', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Ijazah', 'deskripsi' => 'Ijazah Pendidikan (SD, SMP, SMA, S1, S2)', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'SK Konversi NIP Baru', 'deskripsi' => 'Surat Keputusan Konversi NIP Baru', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'SKP', 'deskripsi' => 'Sasaran Kinerja Pegawai', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Taspen', 'deskripsi' => 'Tabungan Asuransi Pegawai Negeri', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Tapera', 'deskripsi' => 'Tabungan Perumahan Rakyat', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'SK Jabatan', 'deskripsi' => 'Surat Keputusan Jabatan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jenis' => 'Sertifikat', 'deskripsi' => 'Sertifikat Pelatihan, Kompetensi, dll.', 'created_at' => now(), 'updated_at' => now()],
            
        ];
        
        foreach ($jenisDokumen as $jenis) {
            DB::table('jenis_dokumen')->updateOrInsert(
                ['nama_jenis' => $jenis['nama_jenis']], // Kondisi untuk mencari
                $jenis // Data yang akan di-insert atau update
            );
        }
    }
}