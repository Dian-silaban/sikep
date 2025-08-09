<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Golongan; // Import model Golongan

class GolonganSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        $golongans = [
            // Golongan untuk PNS
            ['nama_golongan' => 'I A', 'urutan' => 1],
            ['nama_golongan' => 'I B', 'urutan' => 2],
            ['nama_golongan' => 'I C', 'urutan' => 3],
            ['nama_golongan' => 'I D', 'urutan' => 4],
            ['nama_golongan' => 'II A', 'urutan' => 5],
            ['nama_golongan' => 'II B', 'urutan' => 6],
            ['nama_golongan' => 'II C', 'urutan' => 7],
            ['nama_golongan' => 'II D', 'urutan' => 8],
            ['nama_golongan' => 'III A', 'urutan' => 9],
            ['nama_golongan' => 'III B', 'urutan' => 10],
            ['nama_golongan' => 'III C', 'urutan' => 11],
            ['nama_golongan' => 'III D', 'urutan' => 12],
            ['nama_golongan' => 'IV A', 'urutan' => 13],
            ['nama_golongan' => 'IV B', 'urutan' => 14],
            ['nama_golongan' => 'IV C', 'urutan' => 15],
            ['nama_golongan' => 'IV D', 'urutan' => 16],
            
            // Golongan untuk P3K (ditambahkan)
            ['nama_golongan' => 'IX', 'urutan' => 17],
            ['nama_golongan' => 'VIII', 'urutan' => 18],
            ['nama_golongan' => 'VII', 'urutan' => 19],
            ['nama_golongan' => 'VI', 'urutan' => 20],
            ['nama_golongan' => 'V', 'urutan' => 21],
            ['nama_golongan' => 'IV', 'urutan' => 22],
            ['nama_golongan' => 'III', 'urutan' => 23],
            ['nama_golongan' => 'II', 'urutan' => 24],
            ['nama_golongan' => 'I', 'urutan' => 25],
        ];

        foreach ($golongans as $golongan) {
            Golongan::firstOrCreate(['nama_golongan' => $golongan['nama_golongan']], $golongan);
        }
    }
}
