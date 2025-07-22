<?php

namespace App\Exports;

use App\Models\Pegawai;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PegawaiExport implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    WithStrictNullComparison, 
    WithStyles, 
    ShouldAutoSize
{
    protected $selectedColumns;
    protected $filters;
    protected $allExportColumns;

    public function __construct(array $selectedColumns, array $filters, array $allExportColumns)
    {
        $this->selectedColumns = $selectedColumns;
        $this->filters = $filters;
        $this->allExportColumns = $allExportColumns;
    }

    public function collection()
    {
        $query = Pegawai::query();

        if (!empty($this->filters['status']) && $this->filters['status'] != 'all') {
            $query->where('status_pegawai', $this->filters['status']);
        }

        if (!empty($this->filters['unit_kerja_id'])) {
            $query->where('unit_kerja_id', $this->filters['unit_kerja_id']);
        }

        $relationsToLoad = [];
        foreach ($this->selectedColumns as $column) {
            if (Str::contains($column, '.')) {
                $relationsToLoad[] = Str::before($column, '.');
            }
        }
        if (!empty($relationsToLoad)) {
            $query->with(array_unique($relationsToLoad));
        }

        return $query->get();
    }

    public function headings(): array
    {
        $headings = [];
        foreach ($this->selectedColumns as $columnKey) {
            $headings[] = $this->allExportColumns[$columnKey] ?? $columnKey;
        }
        return $headings;
    }

    public function map($pegawai): array
{
    $rowData = [];
    foreach ($this->selectedColumns as $column) {
        $value = null;

        if (\Illuminate\Support\Str::contains($column, '.')) {
            [$relation, $field] = explode('.', $column);
            $value = optional($pegawai->$relation)->$field;
        } else {
            $value = $pegawai->$column;
        }

        // Format tanggal agar aman
        if (in_array($column, ['tanggal_lahir']) && $value) {
            $value = \Carbon\Carbon::parse($value)->format('d-m-Y');
        } elseif (in_array($column, ['created_at', 'updated_at']) && $value) {
            $value = \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s');
        }

        // Tambahkan ' ' untuk NIP dan Nomor Telepon agar dipaksa sebagai teks di Excel
        if (in_array($column, ['nip', 'nomor_telepon', 'nik']) && !empty($value)) {
            $value = ' ' . $value;
        }

        $rowData[] = $value ?? '-';
    }
    return $rowData;
}


    // Styling header
    public function styles(Worksheet $sheet)
    {
        // Header bold + background
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'] // Hijau
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center'
            ]
        ]);

        // Border untuk semua sel
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin',
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);
    }
}
