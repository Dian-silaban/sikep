@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit Dokumen: {{ $dokumen_pegawai->nama_file_asli }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dokumen.update', $dokumen_pegawai->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="jenis_dokumen_id" class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_dokumen_id') is-invalid @enderror" id="jenis_dokumen_id" name="jenis_dokumen_id" required>
                                <option value="">Pilih Jenis Dokumen</option>
                                @foreach ($jenis_dokumen as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_dokumen_id', $dokumen_pegawai->jenis_dokumen_id) == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_dokumen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_file_asli" class="form-label">Nama File Asli <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_file_asli') is-invalid @enderror" id="nama_file_asli" name="nama_file_asli" value="{{ old('nama_file_asli', $dokumen_pegawai->nama_file_asli) }}" required>
                            @error('nama_file_asli')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- BARU: Input untuk TMT Dokumen --}}
                        <div class="mb-3">
                            <label for="tmt_dokumen" class="form-label">TMT Dokumen (Tanggal Mulai Terhitung Dokumen)</label>
                            <input type="date" class="form-control @error('tmt_dokumen') is-invalid @enderror" id="tmt_dokumen" name="tmt_dokumen" value="{{ old('tmt_dokumen', $dokumen_pegawai->tmt_dokumen ? \Carbon\Carbon::parse($dokumen_pegawai->tmt_dokumen)->format('Y-m-d') : '') }}">
                            @error('tmt_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="file_dokumen" class="form-label">Ganti File Dokumen (Opsional)</label>
                            <input type="file" class="form-control @error('file_dokumen') is-invalid @enderror" id="file_dokumen" name="file_dokumen">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengganti file. Max: 30MB (PDF, DOC, DOCX, JPG, JPEG, PNG)</div>
                            @error('file_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $dokumen_pegawai->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-warning">Perbarui Dokumen</button>
                            <a href="{{ route('pegawai.show', $dokumen_pegawai->pegawai_id) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection