@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">

       <div class="report-header-section mb-4 d-flex justify-content-between align-items-center">
            {{-- Hapus div 'report-header-content' karena sudah tidak diperlukan untuk layout ini --}}
            {{-- Judul H2 sekarang menjadi direct child dari report-header-section --}}
            <h2 class="report-title text-white mb-0">Buku Jaga Usulan Kenaikan Gaji Berkala</h2> {{-- Tambahkan text-white dan mb-0 --}}
            
            {{-- Tombol Kembali --}}
            {{-- Tombol ini juga menjadi direct child dari report-header-section --}}
            <a href="{{ route('pegawai.index') }}" class="btn btn-light btn-sm"> {{-- Ganti 'nama.route.index.anda' dengan route yang benar --}}
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Pastikan ini menggunakan 'reports.usulan_berkala.index' --}}
                {{-- Form Filter --}}
<form action="{{ route('reports.usulan-berkala.index') }}" method="GET" class="filter-form mb-4">
    <div class="filter-header">
        <i class="fas fa-filter me-2"></i> Filter
    </div>
    <div class="filter-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="unit_kerja_id" class="form-label">Unit Kerja:</label>
                <select class="form-select filter-input" id="unit_kerja_id" name="unit_kerja_id">
                    <option value="">Semua Unit Kerja</option>
                    {{-- Your existing @foreach loop for unitKerjaList --}}
                    @foreach($unitKerjaList as $unitKerja)
                        <option value="{{ $unitKerja->id }}" {{ $selectedUnitKerjaId == $unitKerja->id ? 'selected' : '' }}>
                            {{ $unitKerja->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="month" class="form-label">Bulan Acuan:</label>
                <select class="form-select filter-input" id="month" name="month">
                    <option value="">Semua Bulan</option>
                    {{-- Your existing @for loop for months --}}
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $selectedMonth == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="year" class="form-label">Tahun Acuan:</label>
                <select class="form-select filter-input" id="year" name="year">
                    {{-- Your existing @for loop for years --}}
                    @for ($y = date('Y') - 5; $y <= date('Y') + 5; $y++)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-center"> {{-- Added d-flex align-items-center for button alignment --}}
                <button type="submit" class="btn btn-primary w-100 filter-button">Filter</button>
            </div>
        </div>
    </div>
</form>

                <div class="d-flex justify-content-between align-items-center mb-3">
    <h6>DAFTAR JAGA USULAN BERKALA</h6> {{-- This text can remain as is, or you can adjust it to match Bezetting style if preferred --}}
    <h6>PERIODE: {{ $selectedMonth ? strtoupper(\Carbon\Carbon::createFromDate(null, $selectedMonth, 1)->translatedFormat('F Y')) : 'SEMUA BULAN ' . $selectedYear }}</h6>
    <form action="{{ route('reports.usulan-berkala.export-excel') }}" method="GET" class="d-inline">
        @csrf
        <input type="hidden" name="unit_kerja_id_export" value="{{ $selectedUnitKerjaId }}">
        <input type="hidden" name="month_export" value="{{ $selectedMonth }}">
        <input type="hidden" name="year_export" value="{{ $selectedYear }}">
        <button type="submit" class="btn-export-excel"> {{-- Changed class to btn-export-excel --}}
            <i class="fas fa-file-excel me-1"></i> Export Excel {{-- Changed icon to fas fa-file-excel --}}
        </button>
    </form>
</div>

                <div class="table-responsive table-container"> {{-- Added table-container class here --}}
    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 14px;"> {{-- Changed font-size to 14px --}}
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

</div> {{-- Closes col-md-9 --}}
</div> {{-- Closes ro--}}
   
@endsection
