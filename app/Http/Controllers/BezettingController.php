<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\Pendidikan;
use App\Models\Golongan;
use App\Models\Eselon; // Pastikan ini ada
use App\Models\BezettingKontrakData; // Pastikan ini ada
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // Pastikan ini ada
use App\Exports\BezettingExport; // Export class baru

class BezettingController extends Controller
{
    /**
     * Menampilkan halaman laporan Bezetting.
     */
    public function index(Request $request)
    {
        // Mendapatkan semua data master untuk filter dropdown
        $unitKerjaList = UnitKerja::orderBy('nama_unit')->get();
        $golonganList = Golongan::orderBy('urutan')->get();
        $pendidikanList = Pendidikan::orderBy('urutan')->get();
        $eselonList = Eselon::orderBy('urutan')->get(); // Ambil data eselon

        // Filter dari request
        $selectedUnitKerjaId = $request->input('unit_kerja_id');
        $selectedMonth = $request->input('month', date('m')); // Default bulan saat ini
        $selectedYear = $request->input('year', date('Y'));   // Default tahun saat ini

        // --- Ambil data Pegawai (PNS) ---
        // Eager load relasi golongan, pendidikan, dan eselon
        $queryPNS = Pegawai::with(['unit_kerja', 'golongan', 'pendidikan', 'eselon']);
        if ($selectedUnitKerjaId) {
            $queryPNS->where('unit_kerja_id', $selectedUnitKerjaId);
        }
        // Hanya ambil pegawai dengan status "Aktif" yang dianggap PNS untuk bezetting
        $queryPNS->where('status_pegawai', 'Aktif');
        $pegawaiPNSData = $queryPNS->get();

        // --- Ambil data Bezetting Kontrak Agregat ---
        $queryKontrak = BezettingKontrakData::with(['unitKerja', 'pendidikan'])
                                            ->where('bulan', $selectedMonth)
                                            ->where('tahun', $selectedYear);
        if ($selectedUnitKerjaId) {
            $queryKontrak->where('unit_kerja_id', $selectedUnitKerjaId);
        }
        $bezettingKontrakAgregat = $queryKontrak->get();

        // Gabungkan dan hitung bezetting
        $bezettingData = $this->calculateBezetting($pegawaiPNSData, $bezettingKontrakAgregat);

        return view('reports.bezetting.index', compact(
            'bezettingData',
            'unitKerjaList',
            'golonganList',
            'pendidikanList',
            'eselonList', // Kirim juga data eselon untuk filter jika diperlukan
            'selectedUnitKerjaId',
            'selectedMonth',
            'selectedYear'
        ));
    }

    /**
     * Melakukan perhitungan bezetting berdasarkan data pegawai PNS dan data kontrak agregat.
     */
    private function calculateBezetting($pegawaiPNSData, $bezettingKontrakAgregat)
    {
        $golonganOrder = ['IV A', 'IV B', 'IV C', 'IV D', 'III A', 'III B', 'III C', 'III D', 'II A', 'II B', 'II C', 'II D', 'I A', 'I B', 'I C', 'I D'];
        $eselonColumns = ['I', 'II', 'III', 'IV', 'JFU']; // Kolom eselon yang relevan di laporan
        $pendidikanColumns = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2']; // Kolom pendidikan

        // Inisialisasi struktur data bezetting
        $bezetting = [];
        foreach ($golonganOrder as $golongan) {
            $bezetting[$golongan] = [
                'golongan' => $golongan,
                'eselon' => array_fill_keys($eselonColumns, 0),
                'pendidikan' => array_fill_keys($pendidikanColumns, 0),
                'total_golongan' => 0,
            ];
        }
        // Inisialisasi baris KONTRAK
        $bezetting['KONTRAK'] = [
            'golongan' => 'KONTRAK',
            'eselon' => array_fill_keys($eselonColumns, 0),
            'pendidikan' => array_fill_keys($pendidikanColumns, 0),
            'total_golongan' => 0,
        ];

        // Total keseluruhan (grand totals)
        $grandTotals = [
            'eselon' => array_fill_keys($eselonColumns, 0),
            'pendidikan' => array_fill_keys($pendidikanColumns, 0),
            'total_keseluruhan' => 0,
        ];

        // --- Proses data Pegawai (PNS) ---
        foreach ($pegawaiPNSData as $pegawai) {
            $golongan = $pegawai->golongan->nama_golongan ?? null;
            $eselonNama = $pegawai->eselon->nama_eselon ?? null; // Ambil nama_eselon langsung dari relasi
            $pendidikan = $pegawai->pendidikan->nama_pendidikan ?? null;

            if ($golongan && isset($bezetting[$golongan])) {
                // Update Eselon berdasarkan nama_eselon (yang sudah sesuai dengan kolom laporan)
                if ($eselonNama && isset($bezetting[$golongan]['eselon'][$eselonNama])) {
                    $bezetting[$golongan]['eselon'][$eselonNama]++;
                    $grandTotals['eselon'][$eselonNama]++;
                }

                // Update Pendidikan
                $pendidikanKey = $this->mapPendidikanToColumn($pendidikan);
                if ($pendidikanKey && isset($bezetting[$golongan]['pendidikan'][$pendidikanKey])) {
                    $bezetting[$golongan]['pendidikan'][$pendidikanKey]++;
                    $grandTotals['pendidikan'][$pendidikanKey]++;
                }

                $bezetting[$golongan]['total_golongan']++;
                $grandTotals['total_keseluruhan']++;
            }
        }

        // --- Proses data Bezetting Kontrak Agregat ---
        foreach ($bezettingKontrakAgregat as $dataKontrak) {
            $eselonCategory = $dataKontrak->eselon_category; // Ini adalah 'nama_eselon' untuk kontrak
            $pendidikanNama = $dataKontrak->pendidikan->nama_pendidikan ?? null;
            $jumlah = $dataKontrak->jumlah_pegawai;

            if (isset($bezetting['KONTRAK'])) {
                // Update Eselon untuk KONTRAK
                if ($eselonCategory && isset($bezetting['KONTRAK']['eselon'][$eselonCategory])) {
                    $bezetting['KONTRAK']['eselon'][$eselonCategory] += $jumlah;
                    $grandTotals['eselon'][$eselonCategory] += $jumlah;
                }

                // Update Pendidikan untuk KONTRAK
                $pendidikanKey = $this->mapPendidikanToColumn($pendidikanNama);
                if ($pendidikanKey && isset($bezetting['KONTRAK']['pendidikan'][$pendidikanKey])) {
                    $bezetting['KONTRAK']['pendidikan'][$pendidikanKey] += $jumlah;
                    $grandTotals['pendidikan'][$pendidikanKey] += $jumlah;
                }

                $bezetting['KONTRAK']['total_golongan'] += $jumlah;
                $grandTotals['total_keseluruhan'] += $jumlah;
            }
        }

        // Tambahkan baris total ke hasil akhir
        $bezetting['TOTAL'] = $grandTotals;

        return $bezetting;
    }

    /**
     * Memetakan string pendidikan dari DB ke nama kolom yang sesuai.
     */
    private function mapPendidikanToColumn($pendidikan)
    {
        $pendidikan = strtoupper($pendidikan);
        if (str_contains($pendidikan, 'SD')) return 'SD';
        if (str_contains($pendidikan, 'SMP')) return 'SMP';
        if (str_contains($pendidikan, 'SMA') || str_contains($pendidikan, 'SMK')) return 'SMA';
        if (str_contains($pendidikan, 'D-I') || str_contains($pendidikan, 'D1')) return 'D-I';
        if (str_contains($pendidikan, 'D-II') || str_contains($pendidikan, 'D2')) return 'D-II';
        if (str_contains($pendidikan, 'D-III') || str_contains($pendidikan, 'D3')) return 'D-III';
        if (str_contains($pendidikan, 'S-1') || str_contains($pendidikan, 'S1') || str_contains($pendidikan, 'SARJANA')) return 'S-1';
        if (str_contains($pendidikan, 'S-2') || str_contains($pendidikan, 'S2') || str_contains($pendidikan, 'MAGISTER')) return 'S-2';
        return null; // Jika tidak ada yang cocok
    }

    /**
     * Mengekspor data bezetting ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $selectedUnitKerjaId = $request->input('unit_kerja_id_export');
        $selectedMonth = $request->input('month_export', date('m'));
        $selectedYear = $request->input('year_export', date('Y'));

        // --- Ambil data Pegawai (PNS) untuk ekspor ---
        $queryPNS = Pegawai::with(['unit_kerja', 'golongan', 'pendidikan', 'eselon']);
        if ($selectedUnitKerjaId) {
            $queryPNS->where('unit_kerja_id', $selectedUnitKerjaId);
        }
        $queryPNS->where('status_pegawai', 'Aktif');
        $pegawaiPNSData = $queryPNS->get();

        // --- Ambil data Bezetting Kontrak Agregat untuk ekspor ---
        $queryKontrak = BezettingKontrakData::with(['unitKerja', 'pendidikan'])
                                            ->where('bulan', $selectedMonth)
                                            ->where('tahun', $selectedYear);
        if ($selectedUnitKerjaId) {
            $queryKontrak->where('unit_kerja_id', $selectedUnitKerjaId);
        }
        $bezettingKontrakAgregat = $queryKontrak->get();

        $bezettingData = $this->calculateBezetting($pegawaiPNSData, $bezettingKontrakAgregat);

        $fileName = 'bezetting_pegawai_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new BezettingExport($bezettingData, $selectedMonth, $selectedYear), $fileName);
    }
}
