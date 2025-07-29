@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Buku Jaga Usulan Kenaikan Gaji Berkala</h5>
            </div>
            <div class="card-body">
                {{-- Pastikan ini menggunakan 'reports.usulan_berkala.index' --}}
                <form action="{{ route('reports.usulan-berkala.index') }}" method="GET" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="unit_kerja_id" class="form-label">Unit Kerja:</label>
                            <select class="form-select" id="unit_kerja_id" name="unit_kerja_id">
                                <option value="">Semua Unit Kerja</option>
                                @foreach($unitKerjaList as $unitKerja)
                                    <option value="{{ $unitKerja->id }}" {{ $selectedUnitKerjaId == $unitKerja->id ? 'selected' : '' }}>
                                        {{ $unitKerja->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="month" class="form-label">Bulan Acuan:</label>
                            <select class="form-select" id="month" name="month">
                                <option value="">Semua Bulan</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $selectedMonth == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label">Tahun Acuan:</label>
                            <select class="form-select" id="year" name="year">
                                @for ($y = date('Y') - 5; $y <= date('Y') + 5; $y++)
                                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6>DAFTAR JAGA USULAN BERKALA</h6>
                    <h6>PERIODE: {{ $selectedMonth ? \Carbon\Carbon::createFromDate(null, $selectedMonth, 1)->translatedFormat('F') : 'Semua Bulan' }} {{ $selectedYear }}</h6>
                    {{-- Pastikan ini menggunakan 'reports.usulan_berkala.export_excel' --}}
                    <form action="{{ route('reports.usulan-berkala.export-excel') }}" method="GET" class="d-inline">
                        @csrf
                        <input type="hidden" name="unit_kerja_id_export" value="{{ $selectedUnitKerjaId }}">
                        <input type="hidden" name="month_export" value="{{ $selectedMonth }}">
                        <input type="hidden" name="year_export" value="{{ $selectedYear }}">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                        </button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 0.85em;">
                        <thead>
                            <tr>
                                <th rowspan="2">NO</th>
                                <th rowspan="2">NAMA/NIP</th>
                                <th rowspan="2">PANGKAT/GOLONGAN</th>
                                <th rowspan="2">TMT</th>
                                <th colspan="{{ count(range($selectedYear - 2, $selectedYear + 5)) }}">TAHUN</th>
                                <th rowspan="2">KET</th>
                            </tr>
                            <tr>
                                @foreach (range($selectedYear - 2, $selectedYear + 5) as $year)
                                    <th>{{ $year }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usulanBerkalaData as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-start">
                                        {{ $data['pegawai']->nama_lengkap }}<br>
                                        <small>{{ $data['pegawai']->nip }}</small>
                                    </td>
                                    <td>{{ $data['pegawai']->golongan->nama_golongan ?? '-' }}</td>
                                    <td>{{ $data['pegawai']->tgl_usulan_berkala_awal ? \Carbon\Carbon::parse($data['pegawai']->tgl_usulan_berkala_awal)->format('d-m-Y') : '-' }}</td>
                                    @foreach (range($selectedYear - 2, $selectedYear + 5) as $year)
                                        <td>{{ $data['proyeksi'][$year] ?? '-' }}</td>
                                    @endforeach
                                    <td>-</td> {{-- Kolom Keterangan --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 4 + count(range($selectedYear - 2, $selectedYear + 5)) + 1 }}">Tidak ada data usulan berkala untuk filter ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
