<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsulanBerkalaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;
    protected $yearsToProject;

    public function __construct(array $data, array $yearsToProject)
    {
        $this->data = $data;
        $this->yearsToProject = $yearsToProject;
    }

    public function collection()
    {
        return collect(array_map(function ($item) {
            $pegawai = $item['pegawai'];
            $row = [
                $pegawai->nama_lengkap,
                ' ' . $pegawai->nip, // supaya tidak diformat otomatis di Excel
                $pegawai->golongan->nama_golongan ?? '-',
                $pegawai->unit_kerja->nama_unit ?? '-',
                $pegawai->tgl_usulan_berkala_awal 
                    ? \Carbon\Carbon::parse($pegawai->tgl_usulan_berkala_awal)->format('d-m-Y')
                    : '-',
            ];
            foreach ($this->yearsToProject as $year) {
                $row[] = $item['proyeksi'][$year] ?? '-';
            }
            return $row;
        }, $this->data));
    }

    public function headings(): array
    {
        $headings = [
            'Nama Pegawai',
            'NIP',
            'Pangkat/Golongan',
            'Unit Kerja',
            'Tgl. Usulan Berkala Awal',
        ];

        foreach ($this->yearsToProject as $year) {
            $headings[] = (string) $year;
        }

        return $headings;
    }
}
