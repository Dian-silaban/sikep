@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar')
    </div>
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Edit Unit Kerja: {{ $unitKerja->nama_unit }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.unit-kerja.update', $unitKerja->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama_unit" class="form-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_unit') is-invalid @enderror" id="nama_unit" name="nama_unit" value="{{ old('nama_unit', $unitKerja->nama_unit) }}" required>
                        @error('nama_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $unitKerja->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    <a href="{{ route('settings.unit-kerja.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection