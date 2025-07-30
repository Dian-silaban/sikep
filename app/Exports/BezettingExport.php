<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class BezettingExport implements FromArray, ShouldAutoSize, WithTitle, WithEvents
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

    public function title(): string
    {
        return 'Bezetting Pegawai';
    }

    public function array(): array
    {
        $data = [];

        $monthNames = [
            '01' => 'JANUARI',
            '02' => 'FEBRUARI',
            '03' => 'MARET',
            '04' => 'APRIL',
            '05' => 'MEI',
            '06' => 'JUNI',
            '07' => 'JULI',
            '08' => 'AGUSTUS',
            '09' => 'SEPTEMBER',
            '10' => 'OKTOBER',
            '11' => 'NOVEMBER',
            '12' => 'DESEMBER'
        ];

        $monthName = isset($monthNames[$this->month]) ? $monthNames[$this->month] : (isset($monthNames[str_pad($this->month, 2, '0', STR_PAD_LEFT)]) ?
            $monthNames[str_pad($this->month, 2, '0', STR_PAD_LEFT)] : strtoupper($this->month));

        $data[] = ['BEZETTING PEGAWAI BPKAD'];
        $data[] = ['BULAN ' . $monthName . ' ' . $this->year];
        $data[] = [];

        $eselonColumns = ['I', 'II', 'III', 'IV', 'JFU'];
        $pendidikanColumns = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2'];
        $golonganOrder = ['IV A', 'IV B', 'IV C', 'IV D', 'III A', 'III B', 'III C', 'III D', 'II A', 'II B', 'II C', 'II D', 'I A', 'I B', 'I C', 'I D', 'IX', 'V'];

        $currentGroupTotalEselon = array_fill_keys($eselonColumns, 0);
        $currentGroupTotalPendidikan = array_fill_keys($pendidikanColumns, 0);
        $currentGroupTotalJumlah = 0;
        $currentMajorGroup = '';

        $repeatingHeaderBlock = [
            ['GOLONGAN', 'ESELON', '', '', '', 'JFU', 'PENDIDIKAN', '', '', '', '', '', '', '', 'JUMLAH'],
            ['', 'I', 'II', 'III', 'IV', '', 'SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2', ''],
        ];

        foreach ($golonganOrder as $golongan) {
            $majorGroupPrefix = substr($golongan, 0, strpos($golongan, ' '));

            if ($majorGroupPrefix !== $currentMajorGroup) {
                $currentMajorGroup = $majorGroupPrefix;
                foreach ($repeatingHeaderBlock as $headerRow) {
                    $data[] = $headerRow;
                }
                $data[] = [];
                $data[] = [];
                $data[] = [];

                $currentGroupTotalEselon = array_fill_keys($eselonColumns, 0);
                $currentGroupTotalPendidikan = array_fill_keys($pendidikanColumns, 0);
                $currentGroupTotalJumlah = 0;
            }

            if (isset($this->bezettingData[$golongan])) {
                $rowData = [$golongan];

                foreach ($eselonColumns as $eselon) {
                    $value = $this->bezettingData[$golongan]['eselon'][$eselon] ?? 0;
                    $rowData[] = $value;
                    $currentGroupTotalEselon[$eselon] += $value;
                }
                foreach ($pendidikanColumns as $pendidikan) {
                    $value = $this->bezettingData[$golongan]['pendidikan'][$pendidikan] ?? 0;
                    $rowData[] = $value;
                    $currentGroupTotalPendidikan[$pendidikan] += $value;
                }
                $totalGolongan = $this->bezettingData[$golongan]['total_golongan'] ?? 0;
                $rowData[] = $totalGolongan;
                $currentGroupTotalJumlah += $totalGolongan;

                $data[] = $rowData;

                if (in_array($golongan, ['IV D', 'III D', 'II D', 'I D'])) {
                    $jumlahRow = ['Jumlah'];
                    foreach ($eselonColumns as $eselon) {
                        $jumlahRow[] = $currentGroupTotalEselon[$eselon];
                    }
                    foreach ($pendidikanColumns as $pendidikan) {
                        $jumlahRow[] = $currentGroupTotalPendidikan[$pendidikan];
                    }
                    $jumlahRow[] = $currentGroupTotalJumlah;
                    $data[] = $jumlahRow;

                    // Setelah JUMLAH, kasih 2 baris kosong baru lanjut header
                    $data[] = [];
                    $data[] = [];

                    $currentGroupTotalEselon = array_fill_keys($eselonColumns, 0);
                    $currentGroupTotalPendidikan = array_fill_keys($pendidikanColumns, 0);
                    $currentGroupTotalJumlah = 0;
                }
            }
        }

        $kontrakRow = ['KONTRAK'];
        if (isset($this->bezettingData['KONTRAK'])) {
            foreach ($eselonColumns as $eselon) {
                $kontrakRow[] = $this->bezettingData['KONTRAK']['eselon'][$eselon] ?? 0;
            }
            foreach ($pendidikanColumns as $pendidikan) {
                $kontrakRow[] = $this->bezettingData['KONTRAK']['pendidikan'][$pendidikan] ?? 0;
            }
            $kontrakRow[] = $this->bezettingData['KONTRAK']['total_golongan'] ?? 0;
        } else {
            $kontrakRow = array_merge($kontrakRow, array_fill(0, count($eselonColumns) + count($pendidikanColumns) + 1, 0));
        }
        $data[] = $kontrakRow;

        $totalRow = ['TOTAL'];
        foreach ($eselonColumns as $eselon) {
            $totalRow[] = $this->grandTotalEselon[$eselon] ?? 0;
        }
        foreach ($pendidikanColumns as $pendidikan) {
            $totalRow[] = $this->grandTotalPendidikan[$pendidikan] ?? 0;
        }
        $totalRow[] = $this->grandTotalJumlah ?? 0;
        $data[] = $totalRow;

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:O1');
                $sheet->getStyle('A1:O1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '000000']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
                ]);

                $sheet->mergeCells('A2:O2');
                $sheet->getStyle('A2:O2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '000000']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
                ]);

                $headerRowContentIdentifierA = 'GOLONGAN';
                $headerRowContentIdentifierB = 'ESELON';
                $headerRowContentIdentifierF = 'JFU';

                $lastRow = $sheet->getHighestDataRow();
                $dataRowCounter = 0;

                for ($row = 1; $row <= $lastRow; $row++) {
                    $cellAValue = $sheet->getCell('A' . $row)->getValue();
                    $isSeparatorRow = (
                        empty($cellAValue) &&
                        (
                            strtoupper($sheet->getCell('A' . ($row - 1))->getValue()) === 'JUMLAH' ||
                            strtoupper($sheet->getCell('A' . ($row + 1))->getValue()) === 'GOLONGAN'
                        )
                    );


                    if (
                        $cellAValue === $headerRowContentIdentifierA &&
                        $sheet->getCell('B' . $row)->getValue() === $headerRowContentIdentifierB &&
                        $sheet->getCell('F' . $row)->getValue() === $headerRowContentIdentifierF
                    ) {

                        $headerStartRow = $row;
                        $headerEndRow = $row + 1;

                        $sheet->mergeCells("A{$headerStartRow}:A{$headerEndRow}");
                        $sheet->mergeCells("B{$headerStartRow}:E{$headerStartRow}");
                        $sheet->mergeCells("F{$headerStartRow}:F{$headerEndRow}");
                        $sheet->mergeCells("G{$headerStartRow}:N{$headerStartRow}");
                        $sheet->mergeCells("O{$headerStartRow}:O{$headerEndRow}");

                        $sheet->getStyle("A{$headerStartRow}:O{$headerEndRow}")->applyFromArray([
                            'font' => ['bold' => false, 'color' => ['rgb' => '000000']],
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '00B050']],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
                        ]);
                        $dataRowCounter = 0;
                        $row += 1;
                    } elseif (strtoupper($cellAValue) === 'JUMLAH') {
                        $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']],
                            'font' => ['bold' => true],
                            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
                        ]);
                        $dataRowCounter = 0;
                    } elseif (strtoupper($cellAValue) === 'KONTRAK') {
                        $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C7E9B0']],
                            'font' => ['bold' => true],
                            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
                        ]);
                        $dataRowCounter = 0;
                    } elseif (strtoupper($cellAValue) === 'TOTAL') {
                        $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']],
                            'font' => ['bold' => true],
                            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
                        ]);
                        $dataRowCounter = 0;
                    } else {
                        $is_initial_fixed_row = ($row >= 1 && $row <= 3);

                        $is_blank_row_after_repeating_header = (
                            $row > 3 &&
                            empty($cellAValue) && empty($sheet->getCell('B' . $row)->getValue()) && empty($sheet->getCell('C' . $row)->getValue())
                        );

                        // BARU: deteksi baris kosong sebelum JUMLAH supaya tidak diwarnai/zebra
                        $is_blank_row_before_jumlah = (
                            $row < $lastRow &&
                            empty($cellAValue) && strtoupper($sheet->getCell('A' . ($row + 1))->getValue()) === 'JUMLAH'
                        );

                        if (!$is_initial_fixed_row && !$is_blank_row_after_repeating_header && !$is_blank_row_before_jumlah) {
                            $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
                            ]);

                            if ($dataRowCounter % 2 == 1) {
                                $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9F9F9']]
                                ]);
                            }
                            $dataRowCounter++;
                        }
                    }
                }

                $sheet->getStyle("A1:O{$lastRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
                ]);

                $sheet->getColumnDimension('A')->setWidth(15);
                for ($col = 'B'; $col <= 'O'; $col++) {
                    $sheet->getColumnDimension($col)->setWidth(8);
                }

                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);

                for ($row = 3; $row <= $lastRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(30);
                }
            }
        ];
    }
}
