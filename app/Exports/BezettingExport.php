<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BezettingExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
{
    protected $bezettingData;
    protected $month;
    protected $year;
    protected $grandTotalEselon;
    protected $grandTotalPendidikan;
    protected $grandTotalJumlah;

    public function __construct(array $bezettingData, $month, $year, $grandTotalEselon, $grandTotalPendidikan, $grandTotalJumlah)
    {
        $this->bezettingData = $bezettingData;
        $this->month = $month;
        $this->year = $year;
        $this->grandTotalEselon = $grandTotalEselon;
        $this->grandTotalPendidikan = $grandTotalPendidikan;
        $this->grandTotalJumlah = $grandTotalJumlah;
    }

    public function view(): View
    {
        return view('settings.bezetting_kontrak.excel', [
            'bezettingData' => $this->bezettingData,
            'month' => $this->month,
            'year' => $this->year,
            'grandTotalEselon' => $this->grandTotalEselon,
            'grandTotalPendidikan' => $this->grandTotalPendidikan,
            'grandTotalJumlah' => $this->grandTotalJumlah,
        ]);
    }

    public function title(): string
    {
        return 'Bezetting Pegawai';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // ✅ Styling judul (baris 1-2)
                $sheet->mergeCells('A1:O1');
                $sheet->mergeCells('A2:O2');
                $sheet->getStyle('A1:O2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => ['rgb' => '000000']
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ]
                ]);

                // ✅ Merge cells untuk header yang rowspan/colspan (baris 4-5)
                $sheet->mergeCells('A4:A5'); // GOLONGAN
                $sheet->mergeCells('B4:F4'); // ESELON
                $sheet->mergeCells('G4:N4'); // PENDIDIKAN  
                $sheet->mergeCells('O4:O5'); // JUMLAH

                // ✅ Styling header (baris 4-5)
                $sheet->getStyle('A4:O5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => '009900'] // Hijau Excel
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);

                // ✅ Styling seluruh tabel dengan border
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A4:O{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['rgb' => '000000']
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ]
                ]);

                // ✅ Styling untuk baris data PNS (zebra striping) - mulai dari baris 6
                for ($row = 6; $row <= $lastRow - 2; $row++) {
                    if (($row - 6) % 2 == 1) { // Baris ganjil
                        $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => 'solid',
                                'startColor' => ['rgb' => 'F9F9F9'] // Abu-abu muda
                            ]
                        ]);
                    }
                }

                // ✅ Baris KONTRAK (hijau muda)
                $contractRow = $lastRow - 1;
                $sheet->getStyle("A{$contractRow}:O{$contractRow}")->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'C7E9B0'] // Hijau muda
                    ],
                    'font' => ['bold' => true]
                ]);

                // ✅ Baris TOTAL (kuning)
                $totalRow = $lastRow;
                $sheet->getStyle("A{$totalRow}:O{$totalRow}")->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'FFFF00'] // Kuning
                    ],
                    'font' => ['bold' => true]
                ]);

                // ✅ Set column widths untuk readability
                $sheet->getColumnDimension('A')->setWidth(12);
                for ($col = 'B'; $col <= 'O'; $col++) {
                    $sheet->getColumnDimension($col)->setWidth(8);
                }

                // ✅ Set row heights
                $sheet->getRowDimension(1)->setRowHeight(20);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(4)->setRowHeight(25);
                $sheet->getRowDimension(5)->setRowHeight(25);
            }
        ];
    }
}