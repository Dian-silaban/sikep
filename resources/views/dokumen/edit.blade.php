@extends('layouts.master')

@section('title', 'Edit Dokumen')

@section('content')
    <div class="form-container">
        <h2 class="form-header">Edit Dokumen: {{ $dokumen_pegawai->nama_file_asli }}</h2>
        <small class="form-hint">Untuk Pegawai: {{ $dokumen_pegawai->pegawai->nama_lengkap }} (NIP: {{ $dokumen_pegawai->pegawai->nip }})</small>

        <form method="POST" action="{{ route('dokumen.update', $dokumen_pegawai->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- PENTING: Untuk metode UPDATE --}}

            <div class="form-group">
                <label for="nama_file_asli">Nama File Dokumen:</label>
                <input type="text" name="nama_file_asli" id="nama_file_asli" value="{{ old('nama_file_asli', $dokumen_pegawai->nama_file_asli) }}" class="form-input-text" required>
            </div>

            <div class="form-group">
                <label for="jenis_dokumen_id">Jenis Dokumen:</label>
                <select name="jenis_dokumen_id" id="jenis_dokumen_id" class="form-select" required>
                    <option value="">Pilih Jenis Dokumen</option>
                    @foreach ($jenis_dokumen as $jenis)
                        <option value="{{ $jenis->id }}" {{ old('jenis_dokumen_id', $dokumen_pegawai->jenis_dokumen_id) == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan (Opsional):</label>
                <textarea name="keterangan" id="keterangan" class="form-textarea">{{ old('keterangan', $dokumen_pegawai->keterangan) }}</textarea>
            </div>

            <div class="form-group">
                <label for="file_dokumen">Upload File Baru (untuk membuat versi baru):</label>
                <input type="file" name="file_dokumen" id="file_dokumen" class="form-input-file">
                <small class="form-hint">Kosongkan jika hanya ingin mengubah detail dokumen. Jika diisi, akan menjadi V{{ $dokumen_pegawai->versi_dokumen + 1 }} dan menggantikan versi aktif saat ini.</small>
                @if ($dokumen_pegawai->path_file)
                    <p class="form-hint">File saat ini: <a href="{{ asset($dokumen_pegawai->path_file) }}" target="_blank" class="btn-aksi btn-info">Lihat File V{{ $dokumen_pegawai->versi_dokumen }}</a></p>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Perbarui Dokumen</button>
                <a href="{{ route('pegawai.show', $dokumen_pegawai->pegawai_id) }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection