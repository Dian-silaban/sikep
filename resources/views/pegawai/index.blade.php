@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')

    <div class="header-pegawai">
        <h2>Daftar Pegawai</h2>
        <p><a href="{{ route('pegawai.create') }}" class="btn-tambah"> + Tambah Pegawai Baru</a></p>
    </div>

    {{-- Form Pencarian --}}
    <form class="form-pencarian" method="GET" action="{{ route('pegawai.index') }}" >
        <input type="text" name="search" placeholder="Cari NIP, Nama, Jabatan, Unit Kerja..." value="{{ $searchTerm ?? '' }}" >
        <button type="submit">Cari</button>
        @if ($searchTerm ?? '')
            <a href="{{ route('pegawai.index') }}" >Reset Pencarian</a>
        @endif
    </form>

    <table class="tabel-daftar">
        <thead>
            <tr>
                <th>No.</th>
                <th>Foto Profil</th>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Unit Kerja</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pegawai as $p)
                <tr>
                    <td>{{ $loop->iteration + $pegawai->firstItem() - 1 }}</td>
                    <td>
                        @if ($p->foto_profil_path)
                            <img src="{{ asset($p->foto_profil_path) }}" alt="Foto Profil {{ $p->nama_lengkap }}">
                        @else
                            {{-- Menggunakan logika default dari controller yang sudah disesuaikan --}}
                            <img src="{{ asset('img/' . ($p->jenis_kelamin == 'Perempuan' ? 'wanita.jpg' : 'pria.jpg')) }}" alt="Foto Profil Default">
                        @endif
                    </td>
                    <td>{{ $p->nip }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->jabatan ?? '-' }}</td>
                    <td>{{ $p->unit_kerja->nama_unit ?? '-' }}</td>
                    <td>
                        {{-- Menambahkan badge status --}}
                        @php
                            $statusClass = '';
                            if ($p->status_pegawai == 'Aktif') {
                                $statusClass = 'aktif';
                            } elseif ($p->status_pegawai == 'Non-aktif') {
                                $statusClass = 'non-aktif';
                            } elseif ($p->status_pegawai == 'Pensiun') {
                                $statusClass = 'pensiun';
                            }
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $p->status_pegawai }}
                        </span>
                    </td>
                    <td class="action-buttons">
                        {{-- Tombol Lihat (ikon mata) --}}
                        <a href="{{ route('pegawai.show', $p->id) }}" class="btn-aksi btn-lihat" title="Lihat">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </a>
                        {{-- Tombol Edit (ikon pensil) --}}
                        <a href="{{ route('pegawai.edit', ['pegawai' => $p->id, '_redirect_to' => request()->fullUrl()]) }}" class="btn-aksi btn-edit" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 15.5v.5H.5a.5.5 0 0 1-.5-.5V.5a.5.5 0 0 1 .5-.5H2V2h2V.5a.5.5 0 0 1 .5-.5h.5a.5.5 0 0 1 .5.5v1.5h1.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.207l6.5-6.5z"/>
                            </svg>
                        </a>
                        {{-- Tombol Hapus (ikon tempat sampah) --}}
                        <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-aksi btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus pegawai {{ $p->nama_lengkap }}?');" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data pegawai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    
   <div class="d-flex justify-content-center mt-4">
    {{ $pegawai->links('vendor.pagination.bootstrap-4') }}
</div>

@endsection
