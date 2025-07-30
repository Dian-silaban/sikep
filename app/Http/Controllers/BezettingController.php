<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\Pendidikan;
use App\Models\Golongan;
use App\Models\Eselon;
use App\Models\BezettingKontrakData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BezettingExport;

class BezettingController extends Controller
{
    /**
     * Menampilkan halaman laporan Bezetting dengan sub-tabel per kelompok golongan.
     */
    public function index(Request $request)
    {
        // Mendapatkan semua data master untuk filter dropdown
        $unitKerjaList = UnitKerja::orderBy('nama_unit')->get();
        $golonganList = Golongan::orderBy('urutan')->get();
        $pendidikanList = Pendidikan::orderBy('urutan')->get();
        $eselonList = Eselon::orderBy('urutan')->get();

        // Filter dari request
        $selectedUnitKerjaId = $request->input('unit_kerja_id');
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // --- Ambil data Pegawai (PNS) ---
        $queryPNS = Pegawai::with(['unit_kerja', 'golongan', 'pendidikan', 'eselon']);
        if ($selectedUnitKerjaId) {
            $queryPNS->where('unit_kerja_id', $selectedUnitKerjaId);
        }
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

        // Data untuk sub-tabel
        $bezettingSubTables = $this->calculateSubTableData($bezettingData);

        return view('reports.bezetting.index', compact(
            'bezettingData',
            'bezettingSubTables',
            'unitKerjaList',
            'golonganList',
            'pendidikanList',
            'eselonList',
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
        // Definisi struktur golongan sesuai dengan kebutuhan sub-tabel
        $allGolongan = ['IV A', 'IV B', 'IV C', 'IV D', 'III A', 'III B', 'III C', 'III D', 
                       'II A', 'II B', 'II C', 'II D', 'I A', 'I B', 'I C', 'I D', 'IX', 'V'];
        $eselonColumns = ['I', 'II', 'III', 'IV', 'JFU'];
        $pendidikanColumns = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2'];

        // Inisialisasi struktur data bezetting
        $bezetting = [];
        foreach ($allGolongan as $golongan) {
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

        // --- Proses data Pegawai (PNS) ---
        foreach ($pegawaiPNSData as $pegawai) {
            $golongan = $pegawai->golongan->nama_golongan ?? null;
            $eselonNama = $pegawai->eselon->nama_eselon ?? null;
            $pendidikan = $pegawai->pendidikan->nama_pendidikan ?? null;

            if ($golongan && isset($bezetting[$golongan])) {
                // Update Eselon
                if ($eselonNama && isset($bezetting[$golongan]['eselon'][$eselonNama])) {
                    $bezetting[$golongan]['eselon'][$eselonNama]++;
                }

                // Update Pendidikan
                $pendidikanKey = $this->mapPendidikanToColumn($pendidikan);
                if ($pendidikanKey && isset($bezetting[$golongan]['pendidikan'][$pendidikanKey])) {
                    $bezetting[$golongan]['pendidikan'][$pendidikanKey]++;
                }

                $bezetting[$golongan]['total_golongan']++;
            }
        }

        // --- Proses data Bezetting Kontrak Agregat ---
        foreach ($bezettingKontrakAgregat as $dataKontrak) {
            $eselonCategory = $dataKontrak->eselon_category;
            $pendidikanNama = $dataKontrak->pendidikan->nama_pendidikan ?? null;
            $jumlah = $dataKontrak->jumlah_pegawai;

            if (isset($bezetting['KONTRAK'])) {
                // Update Eselon untuk KONTRAK
                if ($eselonCategory && isset($bezetting['KONTRAK']['eselon'][$eselonCategory])) {
                    $bezetting['KONTRAK']['eselon'][$eselonCategory] += $jumlah;
                }

                // Update Pendidikan untuk KONTRAK
                $pendidikanKey = $this->mapPendidikanToColumn($pendidikanNama);
                if ($pendidikanKey && isset($bezetting['KONTRAK']['pendidikan'][$pendidikanKey])) {
                    $bezetting['KONTRAK']['pendidikan'][$pendidikanKey] += $jumlah;
                }

                $bezetting['KONTRAK']['total_golongan'] += $jumlah;
            }
        }

        return $bezetting;
    }

    /**
     * Menghitung data untuk sub-tabel berdasarkan kelompok golongan.
     */
    private function calculateSubTableData($bezettingData)
    {
        $golonganGroups = [
            'IV' => ['IV A', 'IV B', 'IV C', 'IV D'],
            'III' => ['III A', 'III B', 'III C', 'III D'],
            'II' => ['II A', 'II B', 'II C', 'II D'],
            'I' => ['I A', 'I B', 'I C', 'I D'],
            'KHUSUS' => ['IX', 'V']
        ];

        $eselonColumns = ['I', 'II', 'III', 'IV', 'JFU'];
        $pendidikanColumns = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2'];
        
        $subTables = [];

        foreach ($golonganGroups as $groupName => $golonganList) {
            $groupTotal = [
                'eselon' => array_fill_keys($eselonColumns, 0),
                'pendidikan' => array_fill_keys($pendidikanColumns, 0),
                'total_golongan' => 0
            ];

            // Hitung total per kelompok
            foreach ($golonganList as $golongan) {
                if (isset($bezettingData[$golongan])) {
                    foreach ($eselonColumns as $eselon) {
                        $groupTotal['eselon'][$eselon] += $bezettingData[$golongan]['eselon'][$eselon] ?? 0;
                    }
                    foreach ($pendidikanColumns as $pendidikan) {
                        $groupTotal['pendidikan'][$pendidikan] += $bezettingData[$golongan]['pendidikan'][$pendidikan] ?? 0;
                    }
                    $groupTotal['total_golongan'] += $bezettingData[$golongan]['total_golongan'] ?? 0;
                }
            }

            $subTables[$groupName] = [
                'golongan_list' => $golonganList,
                'group_total' => $groupTotal
            ];
        }

        return $subTables;
    }

    /**
     * Memetakan string pendidikan dari DB ke nama kolom yang sesuai.
     */
    private function mapPendidikanToColumn($pendidikan)
    {
        if (!$pendidikan) return null;
        
        $pendidikan = strtoupper($pendidikan);
        if (str_contains($pendidikan, 'SD')) return 'SD';
        if (str_contains($pendidikan, 'SMP')) return 'SMP';
        if (str_contains($pendidikan, 'SMA') || str_contains($pendidikan, 'SMK')) return 'SMA';
        if (str_contains($pendidikan, 'D-I') || str_contains($pendidikan, 'D1')) return 'D-I';
        if (str_contains($pendidikan, 'D-II') || str_contains($pendidikan, 'D2')) return 'D-II';
        if (str_contains($pendidikan, 'D-III') || str_contains($pendidikan, 'D3')) return 'D-III';
        if (str_contains($pendidikan, 'S-1') || str_contains($pendidikan, 'S1') || str_contains($pendidikan, 'SARJANA')) return 'S-1';
        if (str_contains($pendidikan, 'S-2') || str_contains($pendidikan, 'S2') || str_contains($pendidikan, 'MAGISTER')) return 'S-2';
        return null;
    }

    /**
     * Mengekspor data bezetting ke Excel dengan format sub-tabel.
     */
    /**
 * Mengekspor data bezetting ke Excel dengan format yang sama persis seperti di web.
 */
/**
 * Mengekspor data bezetting ke Excel dengan format yang sama persis seperti di web.
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

    // Hitung bezetting data
    $bezettingData = $this->calculateBezetting($pegawaiPNSData, $bezettingKontrakAgregat);

    // Hitung grand total untuk export
    $eselonColumns = ['I', 'II', 'III', 'IV', 'JFU'];
    $pendidikanColumns = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2'];
    $golonganOrder = ['IV A','IV B','IV C','IV D','III A','III B','III C','III D','II A','II B','II C','II D','I A','I B','I C','I D'];
    
    $grandTotalEselon = array_fill_keys($eselonColumns, 0);
    $grandTotalPendidikan = array_fill_keys($pendidikanColumns, 0);
    $grandTotalJumlah = 0;
    
    // Hitung grand total dari semua golongan PNS
    foreach($golonganOrder as $golongan) {
        foreach($eselonColumns as $eselon) {
            $grandTotalEselon[$eselon] += $bezettingData[$golongan]['eselon'][$eselon] ?? 0;
        }
        foreach($pendidikanColumns as $pendidikan) {
            $grandTotalPendidikan[$pendidikan] += $bezettingData[$golongan]['pendidikan'][$pendidikan] ?? 0;
        }
        $grandTotalJumlah += $bezettingData[$golongan]['total_golongan'] ?? 0;
    }
    
    // Tambahkan data kontrak ke grand total
    foreach($eselonColumns as $eselon) {
        $grandTotalEselon[$eselon] += $bezettingData['KONTRAK']['eselon'][$eselon] ?? 0;
    }
    foreach($pendidikanColumns as $pendidikan) {
        $grandTotalPendidikan[$pendidikan] += $bezettingData['KONTRAK']['pendidikan'][$pendidikan] ?? 0;
    }
    $grandTotalJumlah += $bezettingData['KONTRAK']['total_golongan'] ?? 0;

    $fileName = 'bezetting_pegawai_' . date('Ymd_His') . '.xlsx';
    return Excel::download(new BezettingExport(
        $bezettingData, 
        $selectedMonth, 
        $selectedYear, 
        $grandTotalEselon, 
        $grandTotalPendidikan, 
        $grandTotalJumlah
    ), $fileName);
}
}