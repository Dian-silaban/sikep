@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar')
    </div>
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manajemen Data Bezetting Kontrak</h5>
                <a href="{{ route('settings.bezetting_kontrak.create_edit') }}" class="btn btn-primary btn-sm">Tambah Data Kontrak</a>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.bezetting_kontrak.index') }}" method="GET" class="mb-4">
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
                            <label for="month" class="form-label">Bulan:</label>
                            <select class="form-select" id="month" name="month">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $selectedMonth == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label">Tahun:</label>
                            <select class="form-select" id="year" name="year">
                                @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
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

                @if ($dataKontrak->isEmpty())
                    <p class="text-center">Belum ada data bezetting kontrak untuk periode ini.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Unit Kerja</th>
                                    <th>Pendidikan</th>
                                    <th>Kategori Eselon</th>
                                    <th>Jumlah Pegawai</th>
                                    <th>Bulan/Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKontrak as $data)
                                <tr>
                                    <td>{{ $data->unitKerja->nama_unit ?? '-' }}</td>
                                    <td>{{ $data->pendidikan->nama_pendidikan ?? '-' }}</td>
                                    <td>{{ $data->eselon_category }}</td>
                                    <td>{{ $data->jumlah_pegawai }}</td>
                                    <td>{{ \Carbon\Carbon::createFromDate($data->tahun, $data->bulan, 1)->translatedFormat('F Y') }}</td>
                                    <td>
                                        <a href="{{ route('settings.bezetting_kontrak.create_edit', ['id' => $data->id]) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('settings.bezetting_kontrak.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
