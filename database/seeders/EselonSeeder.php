<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Eselon; // Import model Eselon


class EselonSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        $eselons = [
            // Kategori Eselon Struktural
            ['nama_eselon' => 'I', 'urutan' => 10],
            ['nama_eselon' => 'II', 'urutan' => 20],
            ['nama_eselon' => 'III', 'urutan' => 30],
            ['nama_eselon' => 'IV', 'urutan' => 40],
            ['nama_eselon' => 'JFU', 'urutan' => 50],
            
            // Jika JFT juga masuk ke JFU di laporan, tidak perlu opsi terpisah di sini.
            // Jika ada kategori lain yang langsung sesuai kolom bezetting, tambahkan di sini.
        ];

        foreach ($eselons as $eselon) {
            Eselon::firstOrCreate(['nama_eselon' => $eselon['nama_eselon']], $eselon);
        }
    }
}
