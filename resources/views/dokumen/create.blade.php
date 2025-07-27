@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Upload Dokumen Baru untuk {{ $pegawai->nama_lengkap }}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pegawai.dokumen.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Jenis Dokumen --}}
                        <div class="mb-3">
                            <label for="jenis_dokumen_id" class="form-label">
                                Jenis Dokumen <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('jenis_dokumen_id') is-invalid @enderror" id="jenis_dokumen_id" name="jenis_dokumen_id" required>
                                <option value="">Pilih Jenis Dokumen</option>
                                @foreach ($jenis_dokumen as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_dokumen_id') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_dokumen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- File Dokumen --}}
                        <div class="mb-3">
                            <label for="file_dokumen" class="form-label">
                                Pilih File Dokumen <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control @error('file_dokumen') is-invalid @enderror" id="file_dokumen" name="file_dokumen" required>
                            <div class="form-text">Max: 30MB (PDF, DOC, DOCX, JPG, JPEG, PNG)</div>
                            @error('file_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TMT Dokumen --}}
                        <div class="mb-3">
                            <label for="tmt_dokumen" class="form-label">
                                TMT Dokumen (Tanggal Mulai Terhitung Dokumen)
                            </label>
                            <input type="date" class="form-control @error('tmt_dokumen') is-invalid @enderror" id="tmt_dokumen" name="tmt_dokumen" value="{{ old('tmt_dokumen') }}">
                            @error('tmt_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">
                                Keterangan  
                            </label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Upload Dokumen</button>
                            <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection