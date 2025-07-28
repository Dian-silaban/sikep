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
                            <label for="unit_kerja_id" class="form-label">Unit Kerja:</label>
                            <select class="form-select filter-input" id="unit_kerja_id" name="unit_kerja_id">
                                <option value="">Semua Unit Kerja</option>
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

            <div class="table-responsive">
                <table class="table-unit-kerja bezetting-table">
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
                            $golonganOrder = ['IV A', 'IV B', 'IV C', 'IV D', 'III A', 'III B', 'III C', 'III D', 'II A', 'II B', 'II C', 'II D', 'I A', 'I B', 'I C', 'I D'];
                            $eselonColumns = ['I', 'II', 'III', 'IV', 'JFU'];
                            $pendidikanColumns = ['SD', 'SMP', 'SMA', 'D-I', 'D-II', 'D-III', 'S-1', 'S-2'];
                            $grandTotalEselon = array_fill_keys($eselonColumns, 0);
                            $grandTotalPendidikan = array_fill_keys($pendidikanColumns, 0);
                            $grandTotalJumlah = 0;
                        @endphp

                        @foreach ($golonganOrder as $golongan)
                            @if (isset($bezettingData[$golongan]))
                                <tr>
                                    <td>{{ $bezettingData[$golongan]['golongan'] }}</td>
                                    @foreach ($eselonColumns as $eselon)
                                        <td>{{ $bezettingData[$golongan]['eselon'][$eselon] }}</td>
                                        @php $grandTotalEselon[$eselon] += $bezettingData[$golongan]['eselon'][$eselon]; @endphp
                                    @endforeach
                                    @foreach ($pendidikanColumns as $pendidikan)
                                        <td>{{ $bezettingData[$golongan]['pendidikan'][$pendidikan] }}</td>
                                        @php $grandTotalPendidikan[$pendidikan] += $bezettingData[$golongan]['pendidikan'][$pendidikan]; @endphp
                                    @endforeach
                                    <td>{{ $bezettingData[$golongan]['total_golongan'] }}</td>
                                    @php $grandTotalJumlah += $bezettingData[$golongan]['total_golongan']; @endphp
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $golongan }}</td>
                                    @foreach ($eselonColumns as $eselon) <td>0</td> @endforeach
                                    @foreach ($pendidikanColumns as $pendidikan) <td>0</td> @endforeach
                                    <td>0</td>
                                </tr>
                            @endif
                        @endforeach

                        {{-- Baris untuk Golongan IX dan V (jika ada di data Anda) --}}
                        @foreach (['IX', 'V'] as $golonganKhusus)
                            @if (isset($bezettingData[$golonganKhusus]))
                                <tr>
                                    <td>{{ $bezettingData[$golonganKhusus]['golongan'] }}</td>
                                    @foreach ($eselonColumns as $eselon)
                                        <td>{{ $bezettingData[$golonganKhusus]['eselon'][$eselon] }}</td>
                                        @php $grandTotalEselon[$eselon] += $bezettingData[$golonganKhusus]['eselon'][$eselon]; @endphp
                                    @endforeach
                                    @foreach ($pendidikanColumns as $pendidikan)
                                        <td>{{ $bezettingData[$golonganKhusus]['pendidikan'][$pendidikan] }}</td>
                                        @php $grandTotalPendidikan[$pendidikan] += $bezettingData[$golonganKhusus]['pendidikan'][$pendidikan]; @endphp
                                    @endforeach
                                    <td>{{ $bezettingData[$golonganKhusus]['total_golongan'] }}</td>
                                    @php $grandTotalJumlah += $bezettingData[$golonganKhusus]['total_golongan']; @endphp
                                </tr>
                            @else
                                {{-- Jika tidak ada data, tampilkan baris dengan 0 --}}
                                <tr>
                                    <td>{{ $golonganKhusus }}</td>
                                    @foreach ($eselonColumns as $eselon) <td>0</td> @endforeach
                                    @foreach ($pendidikanColumns as $pendidikan) <td>0</td> @endforeach
                                    <td>0</td>
                                </tr>
                            @endif
                        @endforeach

                        {{-- Baris KONTRAK --}}
                        @if (isset($bezettingData['KONTRAK']))
                            <tr class="table-secondary fw-bold">
                                <td>KONTRAK</td>
                                @foreach ($eselonColumns as $eselon)
                                    <td>{{ $bezettingData['KONTRAK']['eselon'][$eselon] }}</td>
                                    @php $grandTotalEselon[$eselon] += $bezettingData['KONTRAK']['eselon'][$eselon]; @endphp
                                @endforeach
                                @foreach ($pendidikanColumns as $pendidikan)
                                    <td>{{ $bezettingData['KONTRAK']['pendidikan'][$pendidikan] }}</td>
                                    @php $grandTotalPendidikan[$pendidikan] += $bezettingData['KONTRAK']['pendidikan'][$pendidikan]; @endphp
                                @endforeach
                                <td>{{ $bezettingData['KONTRAK']['total_golongan'] }}</td>
                                @php $grandTotalJumlah += $bezettingData['KONTRAK']['total_golongan']; @endphp
                            </tr>
                        @else
                            <tr class="table-secondary fw-bold">
                                <td>KONTRAK</td>
                                @foreach ($eselonColumns as $eselon) <td>0</td> @endforeach
                                @foreach ($pendidikanColumns as $pendidikan) <td>0</td> @endforeach
                                <td>0</td>
                            </tr>
                        @endif

                        {{-- Baris TOTAL --}}
                        <tr class="table-primary fw-bold">
                            <td>TOTAL</td>
                            @foreach ($eselonColumns as $eselon)
                                <td>{{ $grandTotalEselon[$eselon] }}</td>
                            @endforeach
                            @foreach ($pendidikanColumns as $pendidikan)
                                <td>{{ $grandTotalPendidikan[$pendidikan] }}</td>
                            @endforeach
                            <td>{{ $grandTotalJumlah }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
