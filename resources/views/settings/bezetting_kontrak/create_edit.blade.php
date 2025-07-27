@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar')
    </div>
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">{{ isset($dataKontrak) ? 'Edit Data Bezetting Kontrak' : 'Tambah Data Bezetting Kontrak Baru' }}</h5>
            </div>
            <div class="card-body">
                {{-- Perbaikan di sini: Mengarahkan aksi form berdasarkan mode (create/edit) --}}
                <form action="{{ isset($dataKontrak) ? route('settings.bezetting_kontrak.update', $dataKontrak->id) : route('settings.bezetting_kontrak.store') }}" method="POST">
                    @csrf
                    @if(isset($dataKontrak))
                        @method('PUT') {{-- Gunakan metode PUT untuk update --}}
                    @endif

                    <div class="mb-3">
                        <label for="unit_kerja_id" class="form-label">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select @error('unit_kerja_id') is-invalid @enderror" id="unit_kerja_id" name="unit_kerja_id" required>
                            <option value="">Pilih Unit Kerja</option>
                            @foreach ($unitKerjaList as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_kerja_id', $dataKontrak->unit_kerja_id ?? '') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_kerja_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pendidikan_id" class="form-label">Pendidikan (Opsional)</label>
                        <select class="form-select @error('pendidikan_id') is-invalid @enderror" id="pendidikan_id" name="pendidikan_id">
                            <option value="">Pilih Pendidikan</option>
                            @foreach ($pendidikanList as $pendidikan)
                                <option value="{{ $pendidikan->id }}" {{ old('pendidikan_id', $dataKontrak->pendidikan_id ?? '') == $pendidikan->id ? 'selected' : '' }}>
                                    {{ $pendidikan->nama_pendidikan }}
                                </option>
                            @endforeach
                        </select>
                        @error('pendidikan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="eselon_category" class="form-label">Kategori Eselon (untuk Bezetting) <span class="text-danger">*</span></label>
                        <select class="form-select @error('eselon_category') is-invalid @enderror" id="eselon_category" name="eselon_category" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($eselonCategories as $category)
                                <option value="{{ $category }}" {{ old('eselon_category', $dataKontrak->eselon_category ?? '') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('eselon_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_pegawai" class="form-label">Jumlah Pegawai <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah_pegawai') is-invalid @enderror" id="jumlah_pegawai" name="jumlah_pegawai" value="{{ old('jumlah_pegawai', $dataKontrak->jumlah_pegawai ?? '') }}" required min="0">
                        @error('jumlah_pegawai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                            <select class="form-select @error('bulan') is-invalid @enderror" id="bulan" name="bulan" required>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ old('bulan', $dataKontrak->bulan ?? date('m')) == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                            @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <select class="form-select @error('tahun') is-invalid @enderror" id="tahun" name="tahun" required>
                                @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                    <option value="{{ $y }}" {{ old('tahun', $dataKontrak->tahun ?? date('Y')) == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('settings.bezetting_kontrak.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
