<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\Golongan;
use App\Models\Eselon;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsulanKenaikanPangkatExport; // Export class baru

class UsulanKenaikanPangkatController extends Controller
{
    /**
     * Menampilkan halaman laporan Daftar Jaga Usulan Kenaikan Pangkat (KP).
     */
    public function index(Request $request)
    {
        $unitKerjaList = UnitKerja::orderBy('nama_unit')->get();
        $golonganList = Golongan::orderBy('urutan')->get();
        $eselonList = Eselon::orderBy('urutan')->get();
        $pendidikanList = Pendidikan::orderBy('urutan')->get();

        $selectedUnitKerjaId = $request->input('unit_kerja_id');
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year', date('Y'));

        $query = Pegawai::with(['unit_kerja', 'golongan', 'eselon', 'pendidikan'])
                        ->where('status_pegawai', 'Aktif');

        if ($selectedUnitKerjaId) {
            $query->where('unit_kerja_id', $selectedUnitKerjaId);
        }

        $pegawaiData = $query->get();

        $usulanKenaikanPangkatData = $this->calculateUsulanKenaikanPangkat($pegawaiData, $selectedMonth, $selectedYear);

        return view('reports.usulan_kenaikan_pangkat.index', compact(
            'usulanKenaikanPangkatData',
            'unitKerjaList',
            'golonganList',
            'eselonList',
            'pendidikanList',
            'selectedUnitKerjaId',
            'selectedMonth',
            'selectedYear'
        ));
    }

    /**
     * Melakukan perhitungan usulan kenaikan pangkat.
     */
    private function calculateUsulanKenaikanPangkat($pegawaiData, $filterMonth, $filterYear)
    {
        $proyeksiYears = range($filterYear - 4, $filterYear + 8);
        $usulan = [];

        foreach ($pegawaiData as $pegawai) {
            // Pastikan tgl_usulan_kp_awal ada dan valid
            if (!$pegawai->tgl_usulan_kp_awal) {
                continue;
            }

            try {
                $tglAwal = Carbon::parse($pegawai->tgl_usulan_kp_awal);
                $bulanAcuan = $tglAwal->month;

                $pegawaiUsulan = [
                    'pegawai' => $pegawai,
                    'proyeksi' => [],
                ];

                // Inisialisasi semua tahun dengan null
                foreach ($proyeksiYears as $year) {
                    $pegawaiUsulan['proyeksi'][$year] = null;
                }

                // Hitung proyeksi usulan kenaikan pangkat setiap 4 tahun
                $currentYear = $tglAwal->year;
                
                while ($currentYear <= max($proyeksiYears)) {
                    if (in_array($currentYear, $proyeksiYears)) {
                        // Jika filter bulan tidak ada atau bulan sesuai dengan acuan
                        if (!$filterMonth || $bulanAcuan == $filterMonth) {
                            $pegawaiUsulan['proyeksi'][$currentYear] = Carbon::create($currentYear, $bulanAcuan, 1)->translatedFormat('F');
                        }
                    }
                    $currentYear += 4; // Increment setiap 4 tahun
                }

                $usulan[] = $pegawaiUsulan;

            } catch (\Exception $e) {
                // Skip pegawai jika ada error parsing tanggal
                continue;
            }
        }

        return $usulan;
    }

    /**
     * Mengekspor data usulan kenaikan pangkat ke Excel.
     */
    public function exportExcel(Request $request)
    {
        try {
            $selectedUnitKerjaId = $request->input('unit_kerja_id_export');
            $selectedMonth = $request->input('month_export');
            $selectedYear = $request->input('year_export', date('Y'));

            // Validasi input
            if ($selectedYear < 1900 || $selectedYear > 2100) {
                $selectedYear = date('Y');
            }

            $query = Pegawai::with(['unit_kerja', 'golongan', 'eselon', 'pendidikan'])
                            ->where('status_pegawai', 'Aktif');
            
            if ($selectedUnitKerjaId) {
                $query->where('unit_kerja_id', $selectedUnitKerjaId);
            }
            
            $pegawaiData = $query->get();

            // Pastikan ada data untuk diekspor
            if ($pegawaiData->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data untuk diekspor.');
            }

            $usulanKenaikanPangkatData = $this->calculateUsulanKenaikanPangkat($pegawaiData, $selectedMonth, $selectedYear);

            // Pastikan data usulan tidak kosong
            if (empty($usulanKenaikanPangkatData)) {
                return redirect()->back()->with('error', 'Tidak ada data usulan kenaikan pangkat untuk filter ini.');
            }

            $fileName = 'usulan_kenaikan_pangkat_' . date('Ymd_His') . '.xlsx';
            
            return Excel::download(
                new UsulanKenaikanPangkatExport($usulanKenaikanPangkatData, $selectedMonth, $selectedYear, $selectedUnitKerjaId), 
                $fileName
            );

        } catch (\Exception $e) {
            \Log::error('Error exporting Usulan Kenaikan Pangkat: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Temporary: tampilkan error untuk debugging
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}