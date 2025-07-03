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
            <strong>Unit Kerja</strong>
            {{ $pegawai->unit_kerja->nama_unit ?? '-' }}
        </div>
        <div class="item-kotak">
            <strong>Status Pegawai</strong>
            {{ $pegawai->status_pegawai ?? '-' }}
        </div>
        <div class="item-kotak">
            <strong>Tanggal Bergabung</strong>
            {{ $pegawai->tanggal_bergabung ? \Carbon\Carbon::parse($pegawai->tanggal_bergabung)->format('d-m-Y') : '-' }}
        </div>
    </div>

    <div style="margin-top: 25px;">
        {{-- PERUBAHAN DI SINI: Menambahkan parameter _redirect_to --}}
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
                            <a href="{{ asset($doc->path_file) }}" target="_blank" class="btn-aksi btn-lihat">Lihat</a>
                            <a href="{{ route('dokumen.download', $doc->id) }}" target="_blank" class="btn-aksi btn-unduh">Unduh</a>
                            <form action="{{ route('dokumen.delete', $doc->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Anda akan menghapus dokumen ini secara PERMANEN. Lanjutkan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
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
