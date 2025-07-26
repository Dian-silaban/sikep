@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar')
    </div>
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Edit Jenis Dokumen: {{ $jenisDokuman->nama_jenis }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.jenis-dokumen.update', $jenisDokuman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama_jenis" class="form-label">Nama Jenis Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_jenis') is-invalid @enderror" id="nama_jenis" name="nama_jenis" value="{{ old('nama_jenis', $jenisDokuman->nama_jenis) }}" required>
                        @error('nama_jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $jenisDokuman->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    <a href="{{ route('settings.jenis-dokumen.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection