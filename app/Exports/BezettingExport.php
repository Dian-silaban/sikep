<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class BezettingExport implements FromView, ShouldAutoSize, WithTitle
{
    protected $bezettingData;
    protected $month;
    protected $year;

    public function __construct(array $bezettingData, $month, $year)
    {
        $this->bezettingData = $bezettingData;
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        // Mengarahkan ke view yang akan menjadi template Excel
        return view('settings.bezetting_kontrak.excel', [
            'bezettingData' => $this->bezettingData,
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    public function title(): string
    {
        return 'Bezetting Pegawai';
    }
}
