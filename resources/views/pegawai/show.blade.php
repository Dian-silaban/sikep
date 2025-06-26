@extends('layouts.master')

@section('title', 'Detail Pegawai')

@section('content')
    <h2>Detail Pegawai: {{ $pegawai->nama_lengkap }}</h2>

    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
        @if ($pegawai->foto_profil_path)
            <p><img src="{{ asset($pegawai->foto_profil_path) }}" alt="Foto Profil" style="width: 100px; height: 100px; object-fit: cover;"></p>
        @else
            <p>Tidak ada foto profil.</p>
        @endif
        <p><strong>NIP:</strong> {{ $pegawai->nip }}</p>
        <p><strong>Nama Lengkap:</strong> {{ $pegawai->nama_lengkap }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') : '-' }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $pegawai->jenis_kelamin ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $pegawai->alamat ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $pegawai->email ?? '-' }}</p>
        <p><strong>Nomor Telepon:</strong> {{ $pegawai->nomor_telepon ?? '-' }}</p>
        <p><strong>Jabatan:</strong> {{ $pegawai->jabatan ?? '-' }}</p>
        {{-- PERUBAHAN DI SINI --}}
        <p><strong>Unit Kerja:</strong> {{ $pegawai->unit_kerja->nama_unit ?? '-' }}</p>
        {{-- AKHIR PERUBAHAN --}}
        <p><strong>Status Pegawai:</strong> {{ $pegawai->status_pegawai ?? '-' }}</p>
        <p><strong>Tanggal Bergabung:</strong> {{ $pegawai->tanggal_bergabung ? \Carbon\Carbon::parse($pegawai->tanggal_bergabung)->format('d-m-Y') : '-' }}</p>

        <p>
            <a href="{{ route('pegawai.edit', $pegawai->id) }}">Edit Data Pegawai</a> |
            <a href="{{ route('pegawai.index') }}">Kembali ke Daftar Pegawai</a>
        </p>
    </div>

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
            <label for="keterangan">Keterangan (Opsional):</label><br>
            <textarea name="keterangan" id="keterangan">{{ old('keterangan') }}</textarea>
        </p>
        <p>
            <button type="submit">Unggah Dokumen</button>
        </p>
    </form>

   
{{-- Daftar Dokumen Aktif --}}
 <div style="border: 1px solid #ccc; padding: 15px; margin-top: 20px;">
        <h3>Daftar Semua Dokumen Pegawai (Termasuk Revisi/Non-Aktif)</h3>

        <table border="1" style="width:100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr>
                    <th>Jenis Dokumen</th>
                    <th>Nama File Asli</th>
                    <th>Versi</th>
                    <th>Keterangan</th>
                    <th>Status</th> {{-- TAMBAH KOLOM INI --}}
                    <th>Tgl. Unggah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- PENTING: Ganti $dokumen_aktif menjadi $all_dokumen --}}
                @forelse ($all_dokumen as $doc)
                    <tr style="{{ $doc->status_dokumen == 'Aktif' ? '' : ($doc->status_dokumen == 'Revisi' ? 'background-color: #f0f0f0;' : 'background-color: #ffe0e0; opacity: 0.7;') }}">
                        <td>{{ $doc->jenis_dokumen->nama_jenis ?? '-' }}</td>
                        <td>{{ $doc->nama_file_asli }}</td>
                        <td>V{{ $doc->versi_dokumen }}</td>
                        <td>{{ $doc->keterangan ?? '-' }}</td>
                        <td>
                            {{-- TAMPILKAN STATUS DOKUMEN --}}
                            <strong>{{ $doc->status_dokumen }}</strong>
                        </td>
                        <td>{{ $doc->tanggal_upload->format('d-m-Y H:i') }}</td>
                        <td>
                            {{-- Link Lihat dan Unduh hanya jika status bukan 'Dihapus' --}}
                            @if ($doc->status_dokumen != 'Dihapus')
                                <a href="{{ asset($doc->path_file) }}" target="_blank">Lihat</a> |
                                <a href="{{ route('dokumen.download', $doc->id) }}" target="_blank">Unduh</a> |
                            @else
                                <span style="color: gray;">Tidak Tersedia</span> |
                            @endif

                            {{-- Form non-aktifkan/hapus. Hanya tampilkan tombol non-aktifkan jika status aktif --}}
                            @if ($doc->status_dokumen == 'Aktif')
                                <form action="{{ route('dokumen.destroy', $doc->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin non-aktifkan dokumen ini? File fisik tidak akan dihapus.');">Non-aktifkan</button>
                                </form>
                            @else
                                {{-- Jika dokumen sudah non-aktif/revisi, bisa ditambahkan opsi 'Hapus Permanen' atau 'Aktifkan Kembali' --}}
                                {{-- <span style="color: gray;">Aksi Lain</span> --}}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Tidak ada dokumen untuk pegawai ini.</td> {{-- UBAH COLSPAN MENJADI 7 --}}
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection