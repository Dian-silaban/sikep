@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar') {{-- Atau sidebar khusus laporan jika ada --}}
    </div>
    <div class="col-md-9">
        {{-- NEW REPORT HEADER SECTION --}}
        <div class="report-header-section mb-4">
            <div class="report-header-content">
                <h2 class="report-title">Laporan Bezetting Pegawai</h2>
            </div>
        </div>

        {{-- Existing Filter Form and Table Container --}}
        <div class="table-container">
            <h5 class="mb-3 report-sub-title">BEZETTING PEGAWAI BPKAD KOTA METRO - BULAN {{ \Carbon\Carbon::createFromDate($selectedYear, $selectedMonth, 1)->translatedFormat('F Y') }}</h5>

            {{-- Form Filter --}}
            {{-- PERUBAHAN UTAMA DI SINI: Tambahkan kelas dan struktur baru --}}
            <form action="{{ route('settings.bezetting.index') }}" method="GET" class="filter-form mb-4">
                <div class="filter-header">
                    <i class="fas fa-filter me-2"></i> Filter
                </div>
                <div class="filter-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="unit_kerja_id" class="form-label">Bidang:</label>
                            <select class="form-select filter-input" id="unit_kerja_id" name="unit_kerja_id">
                                <option value="">Semua Bidang</option>
                                @foreach($unitKerjaList as $unitKerja)
                                    <option value="{{ $unitKerja->id }}" {{ $selectedUnitKerjaId == $unitKerja->id ? 'selected' : '' }}>
                                        {{ $unitKerja->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="month" class="form-label">Bulan:</label>
                            <select class="form-select filter-input" id="month" name="month">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $selectedMonth == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label">Tahun:</label>
                            <select class="form-select filter-input" id="year" name="year">
                                @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-center"> {{-- Ubah align-items-end menjadi align-items-center --}}
                            <button type="submit" class="btn btn-primary w-100 filter-button">Filter</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6>BEZETTING PEGAWAI BPKAD KOTA METRO</h6>
                <h6>BULAN {{ strtoupper(\Carbon\Carbon::createFromDate(null, $selectedMonth, 1)->translatedFormat('F Y')) }}</h6>
                <form action="{{ route('settings.bezetting.export_excel') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="unit_kerja_id_export" value="{{ $selectedUnitKerjaId }}">
                    <input type="hidden" name="month_export" value="{{ $selectedMonth }}">
                    <input type="hidden" name="year_export" value="{{ $selectedYear }}">
                    <button type="submit" class="btn-export-excel">
                        <i class="fas fa-file-excel me-1"></i> Export Excel {{-- Menggunakan Font Awesome --}}
                    </button>
                </form>
            </div>

             @php
                    $eselonColumns = ['I', 'II', 'III', 'IV', 'JFU'];
                    $pendidikanColumns = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2'];
                    
                    // Kelompok golongan
                    $golonganGroups = [
                        'IV' => ['IV A', 'IV B', 'IV C', 'IV D'],
                        'III' => ['III A', 'III B', 'III C', 'III D'],
                        'II' => ['II A', 'II B', 'II C', 'II D'],
                        'I' => ['I A', 'I B', 'I C', 'I D'],
                        'KHUSUS' => ['IX', 'V']
                    ];
                @endphp

                {{-- Loop untuk setiap kelompok golongan --}}
                @foreach($golonganGroups as $groupName => $golonganList)
                    <div class="golongan-header">GOLONGAN {{ $groupName }}</div>
                    <div class="table-responsive table-container">
                        <table class="table table-bordered table-sm text-center align-middle" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th rowspan="2">GOLONGAN</th>
                                    <th colspan="5">ESELON</th>
                                    <th colspan="8">PENDIDIKAN</th>
                                    <th rowspan="2">JUMLAH</th>
                                </tr>
                                <tr>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>III</th>
                                    <th>IV</th>
                                    <th>JFU</th>
                                    <th>SD</th>
                                    <th>SMP</th>
                                    <th>SMA</th>
                                    <th>D-I</th>
                                    <th>D-II</th>
                                    <th>D-III</th>
                                    <th>S-1</th>
                                    <th>S-2</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupTotalEselon = array_fill_keys($eselonColumns, 0);
                                    $groupTotalPendidikan = array_fill_keys($pendidikanColumns, 0);
                                    $groupTotalJumlah = 0;
                                @endphp

                                {{-- Baris untuk setiap golongan dalam kelompok --}}
                                @foreach($golonganList as $golongan)
                                    <tr>
                                        <td>{{ $golongan }}</td>
                                        @foreach($eselonColumns as $eselon)
                                            <td>{{ $bezettingData[$golongan]['eselon'][$eselon] ?? 0 }}</td>
                                            @php $groupTotalEselon[$eselon] += $bezettingData[$golongan]['eselon'][$eselon] ?? 0; @endphp
                                        @endforeach
                                        @foreach($pendidikanColumns as $pendidikan)
                                            <td>{{ $bezettingData[$golongan]['pendidikan'][$pendidikan] ?? 0 }}</td>
                                            @php $groupTotalPendidikan[$pendidikan] += $bezettingData[$golongan]['pendidikan'][$pendidikan] ?? 0; @endphp
                                        @endforeach
                                        <td>{{ $bezettingData[$golongan]['total_golongan'] ?? 0 }}</td>
                                        @php $groupTotalJumlah += $bezettingData[$golongan]['total_golongan'] ?? 0; @endphp
                                    </tr>
                                @endforeach

                                {{-- Baris subtotal untuk kelompok --}}
                                <tr class="row-subtotal">
                                    <td><strong>JUMLAH</strong></td>
                                    @foreach($eselonColumns as $eselon)
                                        <td><strong>{{ $groupTotalEselon[$eselon] }}</strong></td>
                                    @endforeach
                                    @foreach($pendidikanColumns as $pendidikan)
                                        <td><strong>{{ $groupTotalPendidikan[$pendidikan] }}</strong></td>
                                    @endforeach
                                    <td><strong>{{ $groupTotalJumlah }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach

                {{-- Tabel Kontrak dan Total Keseluruhan --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th rowspan="2">GOLONGAN</th>
                                <th colspan="5">ESELON</th>
                                <th colspan="8">PENDIDIKAN</th>
                                <th rowspan="2">JUMLAH</th>
                            </tr>
                            <tr>
                                <th>I</th>
                                <th>II</th>
                                <th>III</th>
                                <th>IV</th>
                                <th>JFU</th>
                                <th>SD</th>
                                <th>SMP</th>
                                <th>SMA</th>
                                <th>D-I</th>
                                <th>D-II</th>
                                <th>D-III</th>
                                <th>S-1</th>
                                <th>S-2</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- KONTRAK --}}
                            <tr class="row-kontrak">
                                <td><strong>KONTRAK</strong></td>
                                @foreach($eselonColumns as $eselon)
                                    <td><strong>{{ $bezettingData['KONTRAK']['eselon'][$eselon] ?? 0 }}</strong></td>
                                @endforeach
                                @foreach($pendidikanColumns as $pendidikan)
                                    <td><strong>{{ $bezettingData['KONTRAK']['pendidikan'][$pendidikan] ?? 0 }}</strong></td>
                                @endforeach
                                <td><strong>{{ $bezettingData['KONTRAK']['total_golongan'] ?? 0 }}</strong></td>
                            </tr>

                            {{-- TOTAL KESELURUHAN --}}
                            <tr class="row-total">
                                <td><strong>TOTAL</strong></td>
                                @php
                                    $grandTotalEselon = array_fill_keys($eselonColumns, 0);
                                    $grandTotalPendidikan = array_fill_keys($pendidikanColumns, 0);
                                    $grandTotalJumlah = 0;
                                    
                                    // Hitung grand total
                                    foreach($golonganGroups as $groupName => $golonganList) {
                                        foreach($golonganList as $golongan) {
                                            foreach($eselonColumns as $eselon) {
                                                $grandTotalEselon[$eselon] += $bezettingData[$golongan]['eselon'][$eselon] ?? 0;
                                            }
                                            foreach($pendidikanColumns as $pendidikan) {
                                                $grandTotalPendidikan[$pendidikan] += $bezettingData[$golongan]['pendidikan'][$pendidikan] ?? 0;
                                            }
                                            $grandTotalJumlah += $bezettingData[$golongan]['total_golongan'] ?? 0;
                                        }
                                    }
                                    
                                    // Tambahkan data kontrak
                                    foreach($eselonColumns as $eselon) {
                                        $grandTotalEselon[$eselon] += $bezettingData['KONTRAK']['eselon'][$eselon] ?? 0;
                                    }
                                    foreach($pendidikanColumns as $pendidikan) {
                                        $grandTotalPendidikan[$pendidikan] += $bezettingData['KONTRAK']['pendidikan'][$pendidikan] ?? 0;
                                    }
                                    $grandTotalJumlah += $bezettingData['KONTRAK']['total_golongan'] ?? 0;
                                @endphp
                                
                                @foreach($eselonColumns as $eselon)
                                    <td><strong>{{ $grandTotalEselon[$eselon] }}</strong></td>
                                @endforeach
                                @foreach($pendidikanColumns as $pendidikan)
                                    <td><strong>{{ $grandTotalPendidikan[$pendidikan] }}</strong></td>
                                @endforeach
                                <td><strong>{{ $grandTotalJumlah }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

{{-- Custom CSS untuk gaya Excel --}}
<style>
    .table thead th {
        background: linear-gradient(to bottom, #363d53, #0d3f8b); /* Hijau Excel */
        color: white;
        font-weight: bold;
        text-align: center;
        border: 1px solid #000;
    }

    .table td, .table th {
        text-align: center;
        border: 1px solid #555;
        font-size: 14px;
        padding: 8px;
    }

    .row-subtotal {
        background-color: #ffff99; /* Kuning muda untuk subtotal */
        font-weight: bold;
    }

    .row-kontrak {
        background-color: #c7e9b0; /* Hijau muda */
        font-weight: bold;
    }

    .row-total {
        background-color: #ffff00; /* Kuning */
        font-weight: bold;
    }

    .table tbody tr:nth-child(odd):not(.row-subtotal):not(.row-kontrak):not(.row-total) {
        background-color: #f9f9f9;
    }

    .golongan-header {
        background: linear-gradient(to right, #4a90e2, #6a5acd); 
        font-weight: bold;
        text-align: center;
        padding: 10px;
        margin: 20px 0 10px 0;
        border: 2px solid #c2b9ff;
        font-size: 16px;
        color: white;
    }

    .table-container {
        margin-bottom: 20px;
    }
</style>
@endsection
