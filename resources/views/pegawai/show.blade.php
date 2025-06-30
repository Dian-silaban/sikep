@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
<style>

.container-detail {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.container-detail h2, h3 {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}

/* Info Pegawai */
.detail-info p {
    margin: 5px 0;
    font-size: 15px;
}

.detail-info strong {
    color: #374151;
}

/* Form */
form label {
    font-weight: 500;
    display: block;
    margin-bottom: 5px;
    margin-top: 15px;
}

form select,
form input[type="file"],
form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 14px;
}

form button {
    margin-top: 20px;
    padding: 10px 18px;
    background-color: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

form button:hover {
    background-color: #1e40af;
}

/* Tabel Dokumen */
.table-dokumen {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    font-size: 14px;
}

.table-dokumen th,
.table-dokumen td {
    border: 1px solid #e5e7eb;
    padding: 10px 14px;
    text-align: center;
}

.table-dokumen thead {
    background-color: #363d53;
    color: white;
}

.table-dokumen tr:nth-child(even) {
    background-color: #f9fafb;
}

/* Aksi Link */
.table-dokumen a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    margin: 0 5px;
}

.table-dokumen a:hover {
    text-decoration: underline;
}

button[onclick] {
    background-color: transparent;
    color: red;
    border: none;
    font-weight: 500;
    cursor: pointer;
}

/* Foto */
.foto-profil {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* Responsive */
@media (max-width: 768px) {
    .table-dokumen th, .table-dokumen td {
        font-size: 12px;
        padding: 8px;
    }

    .container-detail {
        padding: 20px;
    }
}

.detail-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.detail-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 20px;
    gap: 30px;
    width: 100%;
}

.detail-column {
    flex: 1;
    min-width: 250px;
}

.detail-info p {
    margin: 8px 0;
    font-size: 15px;
    line-height: 1.5;
}

.detail-grid-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-top: 20px;
}

.detail-card {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.detail-card p {
    margin: 10px 0;
    font-size: 15px;
}

.detail-card strong {
    color: #111827;
}

.foto-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.grid-kotak {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
}

.item-kotak {
    background-color: white;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 10px 15px;
    font-size: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.item-kotak strong {
    display: block;
    margin-bottom: 4px;
    color: #374151;
    font-weight: 600;
}

@media (max-width: 768px) {
    .grid-kotak {
        grid-template-columns: 1fr;
    }
}

.btn-custom {
    display: inline-block;
    padding: 8px 16px;
    margin: 10px 5px 0 0;
    background-color: #2563eb;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    transition: background-color 0.2s ease-in-out;
}

.btn-custom:hover {
    background-color: #1e40af;
}


.action-buttons {

    justify-content: center;
    gap: 6px;
    white-space: nowrap;
    align-items: center;
}

.action-buttons form {
    display: inline-block;
    margin: 0;
}


.btn-aksi {
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 6px;
    font-weight: 500;
    text-decoration: none !important;
    border: none;
    cursor: pointer;
    transition: 0.2s ease-in-out;
    color: #fff !important;
}

.btn-lihat {
    background-color: #3b82f6; /* biru */
    color: white;
}

.btn-lihat:hover {
    background-color: #2563eb;
}

.btn-unduh {
    background-color: #10b981; /* kuning */
    color: white;
}

.btn-unduh:hover {
    background-color: #0e9266;
}
.btn-hapus {
    background-color: #ef4444 !important;/* merah */
    color: white;
    
}

.btn-hapus:hover {
    background-color: #b41f1f !important;
}


</style>
    <h2 style="text-align: center; font-size: 28px; font-weight: 700; margin-bottom: 25px; border-bottom: 2px solid #363d53; padding-bottom: 10px;">
        Detail Pegawai: {{ $pegawai->nama_lengkap }}</h2>

    <div class="container-detail">
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
        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn-custom">Edit Data Pegawai</a> 
        <a href="{{ route('pegawai.index') }}" class="btn-custom">Kembali ke Daftar Pegawai</a>
    </div>
</div>



    <div class="container-detail">
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

    
 <div class="container-detail" >
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
                            {{-- <form action="{{ route('dokumen.delete', $doc->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Anda akan menghapus dokumen ini secara PERMANEN. Lanjutkan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                            </form> --}}
                            <form onsubmit="event.preventDefault(); tampilkanModalHapus('{{ route('dokumen.delete', $doc->id) }}');">
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


<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Penghapusan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin <strong>menghapus dokumen ini secara permanen</strong>?
      </div>
      <div class="modal-footer">
        <form id="formHapusDokumen" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
    function tampilkanModalHapus(actionUrl) {
        const form = document.getElementById('formHapusDokumen');
        form.action = actionUrl;
        const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapus'));
        modal.show();
    }
</script>
@endpush


@endsection