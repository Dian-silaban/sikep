<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\UnitKerja;
use Illuminate\Support\Collection;

class UsulanKenaikanPangkatExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected $usulanKenaikanPangkatData;
    protected $month;
    protected $year;
    protected $unitKerjaId;
    protected $proyeksiYears;

    public function __construct(array $usulanKenaikanPangkatData, $month, $year, $unitKerjaId)
    {
        $this->usulanKenaikanPangkatData = $usulanKenaikanPangkatData;
        $this->month = $month;
        $this->year = $year;
        $this->unitKerjaId = $unitKerjaId;
        $this->proyeksiYears = range($year - 4, $year + 8);
    }

    public function collection()
    {
        return collect($this->usulanKenaikanPangkatData);
    }

    public function map($usulan): array
    {
        static $index = 0;
        $index++;

        $row = [
            $index, // NO
            $usulan['pegawai']->nama_lengkap ?? '-', // NAMA
            $usulan['pegawai']->nip ?? '-', // NIP
            $usulan['pegawai']->golongan->nama_golongan ?? '-', // PANGKAT/GOLONGAN
            $usulan['pegawai']->tgl_usulan_kp_awal ? 
                \Carbon\Carbon::parse($usulan['pegawai']->tgl_usulan_kp_awal)->format('d-m-Y') : '-', // TMT
        ];

        // Tambahkan proyeksi per tahun
        foreach ($this->proyeksiYears as $year) {
            $row[] = $usulan['proyeksi'][$year] ?? '-';
        }

        $row[] = '-'; // Kolom Keterangan

        return $row;
    }

    public function headings(): array
    {
        $headings = [
            'NO',
            'NAMA',
            'NIP', 
            'PANGKAT/GOLONGAN',
            'TMT'
        ];

        // Tambahkan heading tahun
        foreach ($this->proyeksiYears as $year) {
            $headings[] = (string) $year;
        }

        $headings[] = 'KET';

        return $headings;
    }

    public function title(): string
    {
        return 'KP_' . $this->year;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}