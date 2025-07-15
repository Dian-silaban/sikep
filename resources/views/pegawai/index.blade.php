@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')

    <div class="stats-container">
        <div class="stat-card">
            <div class="icon-wrapper total">
                {{-- Icon untuk Total Karyawan (contoh: grup orang) --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#8B0000" class="bi bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 0 5 13c0-1.052.244-2.002.73-2.88.35-.607.676-1.135 1.03-1.652A7.116 7.116 0 0 0 4.5 11c-1.47 0-2.766-.324-3.697-.884C.246 10.156 0 10.082 0 10V9.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H1.085c.67 1.075 1.827 1.745 3.42 1.745.474 0 .92-.066 1.302-.182l.302.264c.545.479 1.002.825 1.348 1.054.346.23.617.348.818.348h.001zm-2.766-.884C.246 10.156 0 10.082 0 10V9.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H1.085c.67 1.075 1.827 1.745 3.42 1.745.474 0 .92-.066 1.302-.182l.302.264c.545.479 1.002.825 1.348 1.054.346.23.617.348.818.348h.001z"/>
                </svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total Karyawan</p>
                <p class="stat-value">{{ $totalPegawai ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper active">
                {{-- Icon untuk Aktif (contoh: centang/check) --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#1e7e34" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Aktif</p>
                <p class="stat-value">{{ $pegawaiAktif ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper non-active">
                {{-- Icon untuk Non-aktif (contoh: silang/cross) --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#d39e00" class="bi bi-person-x-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.854 10.146a.5.5 0 0 1 0-.708L13.293 8l-1.439-1.439a.5.5 0 1 1 .708-.708l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0z"/>
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Non-aktif</p>
                <p class="stat-value">{{ $pegawaiNonAktif ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper retired">
                {{-- Icon untuk Pensiun (contoh: jam pasir/hourglass) --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0f6674" class="bi bi-hourglass-bottom" viewBox="0 0 16 16">
                    <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0 13a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0-.5.5z"/>
                    <path d="M2.5 2a.5.5 0 0 0-.5.5v10.5c0 .354.148.68.417.913.29.25.66.387 1.103.387h7.8a1.5 1.5 0 0 0 1.103-.387c.269-.233.417-.56.417-.913V2.5a.5.5 0 0 0-.5-.5h-11zm0 1h11v10.5c0 .092-.02.176-.057.25-.037.074-.09.13-.153.18L8 9.586 3.71 13.937c-.063-.05-.116-.106-.153-.18-.037-.074-.057-.158-.057-.25V3z"/>
                </svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Pensiun</p>
                <p class="stat-value">{{ $pegawaiPensiun ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="header-pegawai">
        <h2>Daftar Pegawai</h2>
        <p><a href="{{ route('pegawai.create') }}" class="btn-tambah"> + Tambah Pegawai Baru</a></p>
    </div>

    {{-- Form Pencarian --}}
    <form class="form-pencarian" method="GET" action="{{ route('pegawai.index') }}" >
        <input type="text" name="search" placeholder="Cari NIP, Nama, Jabatan, Unit Kerja..." value="{{ $searchTerm ?? '' }}" >
        <button type="submit">Cari</button>
        @if ($searchTerm ?? '')
            <a href="{{ route('pegawai.index') }}" class="btn-reset-pencarian">Reset Pencarian</a>
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



