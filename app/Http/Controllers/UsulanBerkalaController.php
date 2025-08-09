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
use App\Exports\UsulanBerkalaExport;

class UsulanBerkalaController extends Controller
{
    /**
     * Menampilkan halaman laporan Buku Jaga Usulan Berkala (KGB).
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

        $usulanBerkalaData = $this->calculateUsulanBerkala($pegawaiData, $selectedMonth, $selectedYear);

        return view('reports.usulan_berkala.index', compact(
            'usulanBerkalaData',
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
     * Melakukan perhitungan usulan kenaikan gaji berkala.
     */
    private function calculateUsulanBerkala($pegawaiData, $filterMonth, $filterYear)
    {
        $proyeksiYears = range($filterYear - 2, $filterYear + 5); 
        $usulan = [];

        foreach ($pegawaiData as $pegawai) {
            if (!$pegawai->tgl_usulan_berkala_awal) {
                continue; 
            }

            $tglAwal = Carbon::parse($pegawai->tgl_usulan_berkala_awal);
            $bulanAcuan = $tglAwal->month;

            $pegawaiUsulan = [
                'pegawai' => $pegawai,
                'proyeksi' => array_fill_keys($proyeksiYears, null),
            ];

            foreach ($proyeksiYears as $year) {
                $currentProjectedYear = $tglAwal->year;
                $currentProjectedMonth = $tglAwal->month;

                while ($currentProjectedYear <= $year) {
                    if ($currentProjectedYear == $year) {
                        if (!$filterMonth || $bulanAcuan == $filterMonth) {
                            $pegawaiUsulan['proyeksi'][$year] = Carbon::create($year, $bulanAcuan, 1)->translatedFormat('F');
                            break;
                        }
                    }
                    $currentProjectedYear += 2;
                }
            }
            $usulan[] = $pegawaiUsulan;
        }

        return $usulan;
    }

    /**
     * Mengekspor data usulan berkala ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $selectedUnitKerjaId = $request->input('unit_kerja_id_export');
        $selectedMonth = $request->input('month_export');
        $selectedYear = $request->input('year_export', date('Y'));

        $query = Pegawai::with(['unit_kerja', 'golongan', 'eselon', 'pendidikan'])
                        ->where('status_pegawai', 'Aktif');

        if ($selectedUnitKerjaId) {
            $query->where('unit_kerja_id', $selectedUnitKerjaId);
        }

        $pegawaiData = $query->get();

        $usulanBerkalaData = $this->calculateUsulanBerkala($pegawaiData, $selectedMonth, $selectedYear);

        // Hitung range proyeksi tahun untuk dikirim ke export
        $proyeksiYears = range($selectedYear - 2, $selectedYear + 5);

        $fileName = 'usulan_berkala_' . date('Ymd_His') . '.xlsx';

        return Excel::download(
            new UsulanBerkalaExport($usulanBerkalaData, $proyeksiYears),
            $fileName
        );
    }
}