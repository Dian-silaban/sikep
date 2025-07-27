<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pendidikan; // Import model Pendidikan

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendidikans = [
            ['nama_pendidikan' => 'SD', 'jenjang' => 'Dasar', 'urutan' => 10],
            ['nama_pendidikan' => 'SMP', 'jenjang' => 'Menengah', 'urutan' => 20],
            ['nama_pendidikan' => 'SMA', 'jenjang' => 'Menengah', 'urutan' => 30],
            ['nama_pendidikan' => 'SMK', 'jenjang' => 'Menengah', 'urutan' => 35],
            ['nama_pendidikan' => 'D-I', 'jenjang' => 'Diploma', 'urutan' => 40],
            ['nama_pendidikan' => 'D-II', 'jenjang' => 'Diploma', 'urutan' => 50],
            ['nama_pendidikan' => 'D-III', 'jenjang' => 'Diploma', 'urutan' => 60],
            ['nama_pendidikan' => 'D-IV', 'jenjang' => 'Diploma', 'urutan' => 70],
            ['nama_pendidikan' => 'S-1', 'jenjang' => 'Sarjana', 'urutan' => 80],
            ['nama_pendidikan' => 'S-2', 'jenjang' => 'Magister', 'urutan' => 90],
            ['nama_pendidikan' => 'S-3', 'jenjang' => 'Doktor', 'urutan' => 100],
        ];

        foreach ($pendidikans as $pendidikan) {
            Pendidikan::firstOrCreate(['nama_pendidikan' => $pendidikan['nama_pendidikan']], $pendidikan);
        }
    }
}
