@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')

    <h2 style="text-align: center; font-size: 28px; font-weight: 700; margin-bottom: 25px; border-bottom: 2px solid #363d53; padding-bottom: 10px;">
        Detail Pegawai: {{ $pegawai->nama_lengkap }}</h2>

    <div class="container-detail-show">
    <div class="foto-wrapper">
        @if ($pegawai->foto_profil_path)
            <img src="{{ asset($pegawai->foto_profil_path) }}" alt="Foto Profil" class="foto-profil">
        @else
            <p>Tidak ada foto profil.</p>
        @endif
    </div>

    <div class="grid-kotak">
        <div class="item-kotak">
            <strong>NIP</strong>
            {{ $pegawai->nip }}
        </div>
        <div class="item-kotak">
            <strong>NIK</strong>
            {{ $pegawai->nik ?? '-' }}
        </div> 
        <div class="item-kotak">
            <strong>Nama Lengkap</strong>
            {{ $pegawai->nama_lengkap }}
        </div>
        <div class="item-kotak">
            <strong>Tanggal Lahir</strong>
            {{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') : '-' }}
        </div>
        <div class="item-kotak">
            <strong>Jenis Kelamin</strong>
            {{ $pegawai->jenis_kelamin ?? '-' }}
        </div>
        <div class="item-kotak">
            <strong>Alamat</strong>
            {{ $pegawai->alamat ?? '-' }}
        </div>
        <div class="item-kotak">
            <strong>Email</strong>
            {{ $pegawai->email ?? '-' }}
        </div>
        <div class="item-kotak">
            <strong>Nomor Telepon</strong>
            {{ $pegawai->nomor_telepon ?? '-' }}
        </div>
        <div class="item-kotak">
            <strong>Jabatan</strong>
            {{ $pegawai->jabatan ?? '-' }}
        </div>
        <div class="item-kotak">
            <strong>Pangkat dan Golongan</strong>
            {{ $pegawai->golongan_pangkat ?? '-' }}
        </div>   
        <div class="item-kotak">
            <strong>Unit Kerja</strong>
            {{ $pegawai->unit_kerja->nama_unit ?? '-' }}
        </div>
        <div class="item-kotak">
            <strong>Status Pegawai</strong>
            {{ $pegawai->status_pegawai ?? '-' }}
        </div>
    </div>

    <div style="margin-top: 25px;">
         
        <a href="{{ route('pegawai.edit', ['pegawai' => $pegawai->id, '_redirect_to' => request()->fullUrl()]) }}" class="btn-custom-edit">Edit Data Pegawai</a>
        <a href="{{ route('pegawai.index') }}" class="btn-custom-edit">Kembali ke Daftar Pegawai</a>
    </div>
</div>

<div class="container-detail-show" >
    <h3>Unggah Dokumen Baru</h3>
    <form method="POST" action="{{ route('pegawai.dokumen.store', $pegawai->id) }}" enctype="multipart/form-data">
        @csrf
        <p>
            <label for="jenis_dokumen_id">Jenis Dokumen:</label><br>
            <select name="jenis_dokumen_id" id="jenis_dokumen_id" required>
                <option value="">Pilih Jenis Dokumen</option>
                @foreach ($jenis_dokumen as $jenis)
                    <option value="{{ $jenis->id }}" {{ old('jenis_dokumen_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                @endforeach
            </select>
        </p>
        <p>
            <label for="file_dokumen">File Dokumen:</label><br>
            <input type="file" name="file_dokumen" id="file_dokumen" required>
        </p>
        <p>
            <label for="keterangan">Keterangan (Asli/FotoCopy):</label><br>
            <textarea name="keterangan" id="keterangan">{{ old('keterangan') }}</textarea>
        </p>
        <p>
            <button type="submit">Unggah Dokumen</button>
        </p>
    </form>
</div>


<div class="container-detail-show" >
        <h3>Daftar Semua Dokumen Pegawai (Termasuk Revisi/Non-Aktif)</h3>

        <table class="table-dokumen">
            <thead>
                <tr>
                    <th>Jenis Dokumen</th>
                    <th>Nama File Asli</th>
                    <th>Versi</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Tgl. Unggah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($all_dokumen as $doc)
                    <tr style="{{ $doc->status_dokumen == 'Revisi' ? 'background-color: #f0f0f0;' : '' }}">
                        <td>{{ $doc->jenis_dokumen->nama_jenis ?? '-' }}</td>
                        <td>{{ $doc->nama_file_asli }}</td>
                        <td>V{{ $doc->versi_dokumen }}</td>
                        <td>{{ $doc->keterangan ?? '-' }}</td>
                        <td>
                            <strong>{{ $doc->status_dokumen }}</strong>
                        </td>
                        <td>{{ $doc->tanggal_upload->format('d-m-Y H:i') }}</td>
                        <td class="action-buttons">
  {{-- Tombol Lihat --}}
  <a href="{{ asset($doc->path_file) }}" target="_blank" class="btn-aksi btn-lihat" title="Lihat Dokumen">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
      <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
      <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
    </svg>
  </a>

  {{-- Tombol Unduh --}}
  <a href="{{ route('dokumen.download', $doc->id) }}" target="_blank" class="btn-aksi btn-unduh" title="Unduh Dokumen">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
      <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.6a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5V10.4a.5.5 0 0 1 1 0v2.6a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13V10.4a.5.5 0 0 1 .5-.5z"/>
      <path d="M7.646 10.854a.5.5 0 0 0 .708 0L11 8.207V1.5a.5.5 0 0 0-1 0v6.793L8.354 5.146a.5.5 0 1 0-.708.708L10.293 9H6.707l2.647-2.646a.5.5 0 0 0-.708-.708L5 9.793 7.646 10.854z"/>
    </svg>
  </a>
    
  {{-- Tombol Rename --}}
<a href="{{ route('dokumen.edit', $doc->id) }}" class="btn-aksi btn-rename" title="Rename Dokumen">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
       class="bi bi-pencil-fill" viewBox="0 0 16 16">
    <path d="M12.854.146a.5.5 0 0 1 .707 0l2.293 2.293a.5.5 0 0 1 0 .707l-9.5 9.5a.5.5 0 0 1-.168.11l-5 
             2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5zM11.207 2.5 13.5 4.793 
             12.5 5.793 10.207 3.5 11.207 2.5zm1.586 3L10.5 3.207l-8.646 8.647-.854 
             2.146 2.146-.854L12.793 5.5z"/>
  </svg>
</a>

    
  {{-- Tombol Hapus --}}
  <form action="{{ route('dokumen.delete', $doc->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('PERINGATAN! Anda akan menghapus dokumen ini secara PERMANEN. Lanjutkan?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-aksi btn-hapus" title="Hapus Dokumen">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
      </svg>
    </button>
  </form>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Tidak ada dokumen aktif atau revisi untuk pegawai ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
