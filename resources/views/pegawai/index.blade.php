@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')

<div class="stats-container">
    <div class="stat-card">
        <div class="icon-wrapper total">
            {{-- Icon untuk Total Karyawan (contoh: grup orang) --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#8B0000" class="bi bi-people-fill" viewBox="0 0 16 16">
                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 0 5 13c0-1.052.244-2.002.73-2.88.35-.607.676-1.135 1.03-1.652A7.116 7.116 0 0 0 4.5 11c-1.47 0-2.766-.324-3.697-.884C.246 10.156 0 10.082 0 10V9.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H1.085c.67 1.075 1.827 1.745 3.42 1.745.474 0 .92-.066 1.302-.182l.302.264c.545.479 1.002.825 1.348 1.054.346.23.617.348.818.348h.001zm-2.766-.884C.246 10.156 0 10.082 0 10V9.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H1.085c.67 1.075 1.827 1.745 3.42 1.745.474 0 .92-.066 1.302-.182l.302.264c.545.479 1.002.825 1.348 1.054.346.23.617.348.818.348h.001z" />
            </svg>
        </div>
        <div class="stat-info">
            <p class="stat-label">Total Karyawan</p>
            <p class="stat-value">{{ $totalPegawai ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon-wrapper active">
            {{-- Icon for Active (e.g., checkmark) --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#1e7e34" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
            </svg>
        </div>
        <div class="stat-info">
            <p class="stat-label">Aktif</p>
            <p class="stat-value">{{ $pegawaiAktif ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon-wrapper non-active">
            {{-- Icon for Inactive (e.g., cross) --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#d39e00" class="bi bi-person-x-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.854 10.146a.5.5 0 0 1 0-.708L13.293 8l-1.439-1.439a.5.5 0 1 1 .708-.708l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0z" />
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
            </svg>
        </div>
        <div class="stat-info">
            <p class="stat-label">Pindah</p>
            <p class="stat-value">{{ $pegawaiNonAktif ?? 0 }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon-wrapper retired">
            {{-- Icon for Retired (e.g., hourglass) --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#0f6674" class="bi bi-hourglass-bottom" viewBox="0 0 16 16">
                <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0 13a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0-.5.5z" />
                <path d="M2.5 2a.5.5 0 0 0-.5.5v10.5c0 .354.148.68.417.913.29.25.66.387 1.103.387h7.8a1.5 1.5 0 0 0 1.103-.387c.269-.233.417-.56.417-.913V2.5a.5.5 0 0 0-.5-.5h-11zm0 1h11v10.5c0 .092-.02.176-.057.25-.037.074-.09.13-.153.18L8 9.586 3.71 13.937c-.063-.05-.116-.106-.153-.18-.037-.074-.057-.158-.057-.25V3z" />
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
    <p>
        <button type="button" class="btn-tambah" style="border: none;" data-bs-toggle="modal" data-bs-target="#tambahPegawaiModal">
            + Tambah Pegawai Baru
        </button>
        <button type="button" class="btn-tambah" style="border: none; background-color: #28a745;" data-bs-toggle="modal" data-bs-target="#exportOptionsModal">
            Export Excel
        </button>
    </p>
</div>

{{-- Search and Filter Forms --}}
<form class="form-pencarian" method="GET" action="{{ route('pegawai.index') }}">
    <div class="input-group">
        <input type="text" name="search" placeholder="Cari NIP, Nama, Jabatan, Bidang..." value="{{ $searchTerm ?? '' }}">
        <button type="submit">Cari</button>
        @if ($searchTerm ?? '')
        <a href="{{ route('pegawai.index') }}" class="btn-reset-pencarian">Reset Pencarian</a>
        @endif
    </div>
</form>

<form class="form-pencarian" method="GET" action="{{ route('pegawai.index') }}">
    <div class="box" style="display: flex">
        <div class="unit" style="height: 44px;">
            <select class="filter" name="unit_kerja">
                <option value="">Bidang</option>
                @foreach($unitKerjaList as $unit)
                <option value="{{ $unit->id }}" {{ (isset($unitKerjaFilter) && $unitKerjaFilter == $unit->id) ? 'selected' : '' }}>
                    {{ $unit->nama_unit }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="status" style="height: 44px; ">
            <select class="filter" name="status_pegawai">
                <option value="">Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Non-aktif">Pindah</option>
                <option value="Pensiun">Pensiun</option>
            </select>
        </div>
        <div class="btn-filter">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
        <div>
            @if ($searchTerm || $unitKerjaFilter || $statusFilter)
            <a href="{{ route('pegawai.index') }}" class="btn-reset-pencarian">Reset</a>
            @endif
        </div>
    </div>
</form>

<table class="tabel-daftar">
    <thead>
        <tr>
            <th>No.</th>
            <th>Foto Profil</th>
            <th>NIP</th>
            <th>Nama Lengkap</th>
            <th>Jabatan</th>
            <th>Bidang</th>
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
                <img src="{{ asset($p->foto_profil_path) }}" alt="Foto Profil {{ $p->nama_lengkap }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                @else
                <img src="{{ asset('img/' . ($p->jenis_kelamin == 'Perempuan' ? 'wanita.jpg' : 'pria.jpg')) }}" alt="Foto Profil Default" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                @endif
            </td>
            <td>{{ $p->nip }}</td>
            <td>{{ $p->nama_lengkap }}</td>
            <td>{{ $p->jabatan ?? '-' }}</td>
            <td>{{ $p->unit_kerja->nama_unit ?? '-' }}</td>
            <td>
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
                    {{ $p->status_pegawai == 'Non-aktif' ? 'Pindah' : $p->status_pegawai }}
                </span>
                @if ($p->tmt)
                <br><small class="text-muted" style="font-size: 0.85em;">TMT: {{ \Carbon\Carbon::parse($p->tmt)->format('d-m-Y') }}</small>
                @endif
            </td>
            <td class="action-buttons">
                <a href="{{ route('pegawai.show', $p->id) }}" class="btn-aksi btn-lihat" title="Lihat">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-eye-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                    </svg>
                </a>
                <button type="button" class="btn-aksi btn-edit" title="Edit"
                    data-bs-toggle="modal" data-bs-target="#editPegawaiModal"
                    data-id="{{ $p->id }}"
                    data-nip="{{ $p->nip }}"
                    data-nik="{{ $p->nik ?? '' }}"
                    data-nama-lengkap="{{ $p->nama_lengkap }}"
                    data-tanggal-lahir="{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('Y-m-d') : '' }}"
                    data-jenis-kelamin="{{ $p->jenis_kelamin ?? '' }}"
                    data-alamat="{{ $p->alamat ?? '' }}"
                    data-email="{{ $p->email ?? '' }}"
                    data-nomor-telepon="{{ $p->nomor_telepon ?? '' }}"
                    data-jabatan="{{ $p->jabatan ?? '' }}"
                    data-tmt="{{ $p->tmt ? \Carbon\Carbon::parse($p->tmt)->format('Y-m-d') : '' }}"
                    data-eselon-id="{{ $p->eselon_id ?? '' }}"
                    data-golongan-id="{{ $p->golongan_id ?? '' }}"
                    data-pendidikan-id="{{ $p->pendidikan_id ?? '' }}"
                    data-golongan-pangkat="{{ $p->golongan_pangkat ?? '' }}"
                    data-unit-kerja-id="{{ $p->unit_kerja_id ?? '' }}"
                    data-status-pegawai="{{ $p->status_pegawai ?? '' }}"
                    data-tmt-status="{{ $p->tmt_status ? \Carbon\Carbon::parse($p->tmt_status)->format('Y-m-d') : '' }}"
                    {{-- BARU: Menambahkan atribut data untuk tanggal berkala dan KP --}}
                    data-tgl-usulan-berkala-awal="{{ $p->tgl_usulan_berkala_awal ? \Carbon\Carbon::parse($p->tgl_usulan_berkala_awal)->format('Y-m-d') : '' }}"
                    data-tgl-usulan-kp-awal="{{ $p->tgl_usulan_kp_awal ? \Carbon\Carbon::parse($p->tgl_usulan_kp_awal)->format('Y-m-d') : '' }}"
                    data-foto-profil-path="{{ $p->foto_profil_path ? asset($p->foto_profil_path) : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 15.5v.5H.5a.5.5 0 0 1-.5-.5V.5a.5.5 0 0 1 .5-.5H2V2h2V.5a.5.5 0 0 1 .5-.5h.5a.5.5 0 0 1 .5.5v1.5h1.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.207l6.5-6.5z" />
                    </svg>
                </button>
                <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-aksi btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus pegawai {{ $p->nama_lengkap }}?');" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
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

{{-- Modal Export Excel --}}
<div class="modal fade" id="exportOptionsModal" tabindex="-1" aria-labelledby="exportOptionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportOptionsLabel">Pilih Data untuk Export</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm" action="{{ route('pegawai.export.excel') }}" method="GET">
                    <p class="fw-bold">Pilih Kolom yang Akan Diexport:</p>
                    <div class="row">
                        @php
                        $exportColumns = [
                        'nip' => 'NIP',
                        'nik' => 'NIK',
                        'nama_lengkap' => 'Nama Lengkap',
                        'nomor_telepon' => 'No. Telepon',
                        'unit_kerja.nama_unit' => 'Bidang',
                        'jabatan' => 'Jabatan',
                        'golongan_pangkat' => 'Pangkat',
                        'status_pegawai' => 'Status',
                        'alamat' => 'Alamat',
                        'tanggal_lahir' => 'Tanggal Lahir',
                        'jenis_kelamin' => 'Jenis Kelamin',
                        'email' => 'Email',
                        ];
                        @endphp
                        @foreach ($exportColumns as $key => $label)
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="columns[]" value="{{ $key }}" id="column_{{ $key }}" checked>
                                <label class="form-check-label" for="column_{{ $key }}">
                                    {{ $label }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr class="my-4">
                    <p class="fw-bold">Filter Data (Opsional):</p>
                    <div class="mb-3">
                        <label for="status_filter" class="form-label">Status Pegawai:</label>
                        <select class="form-select" id="status_filter" name="status_filter">
                            <option value="all">Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Non-aktif">Pindah</option>
                            <option value="Pensiun">Pensiun</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unit_kerja_filter_modal" class="form-label">Bidang:</label>
                        <select class="form-select" id="unit_kerja_filter_modal" name="unit_kerja_filter">
                            <option value="">Bidang</option>
                            @foreach ($unitKerjaList as $unit)
                            <option value="{{ $unit->id }}">
                                {{ $unit->nama_unit }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="exportForm">Export Excel</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Pegawai Baru --}}
<div class="modal fade" id="tambahPegawaiModal" tabindex="-1" aria-labelledby="tambahPegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPegawaiModalLabel" style="text-align:center;">Tambah Pegawai Baru</h5>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group text-center mb-4">
                        <label for="foto_profil" class="d-block mb-2">Foto Profil:</label>
                        <div class="profile-photo-upload-container">
                            <img id="profile-preview-image" src="{{ asset('img/no-photo.jpg') }}" alt="No Photo" class="profile-photo-preview">
                            <button type="button" id="upload-new-button" class="btn btn-sm btn-outline-primary upload-button">Unggah</button>
                            <input type="file" name="foto_profil" id="foto_profil" class="d-none">
                        </div>
                    </div>
                    <div class="form-grid mt-3">
                        <p class="form-group">
                            <label for="nip">NIP:</label>
                            <input type="text" name="nip" id="nip" value="{{ old('nip') }}" required>
                        </p>
                        <p class="form-group">
                            <label for="nik">NIK:</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}">
                        </p>
                        <p class="form-group">
                            <label for="nama_lengkap">Nama Lengkap:</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                        </p>
                        <p class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir:</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                        </p>
                        <p class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="jenis_kelamin">
                                <option value="">Pilih</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </p>
                        <p class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}">
                        </p>
                        <p class="form-group">
                            <label for="nomor_telepon">Nomor Telepon:</label>
                            <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}">
                        </p>
                        <p class="form-group">
                            <label for="jabatan">Jabatan:</label>
                            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" required>
                        </p>
                        <p class="form-group">
                            <label for="golongan_id">Golongan:</label>
                            <select name="golongan_id" id="golongan_id">
                                <option value="">Pilih Golongan</option>
                                @foreach ($golongans as $golongan)
                                <option value="{{ $golongan->id }}" {{ old('golongan_id') == $golongan->id ? 'selected' : '' }}>
                                    {{ $golongan->nama_golongan }}
                                </option>
                                @endforeach
                            </select>
                        </p>
                        <p class="form-group">
                            <label for="tmt">TMT Golongan:</label>
                            <input type="date" name="tmt" id="tmt" value="{{ old('tmt') }}">
                        </p>
                        <p class="form-group">
                            <label for="eselon_id">Eselon:</label>
                            <select name="eselon_id" id="eselon_id">
                                <option value="">Pilih Eselon</option>
                                @foreach ($eselons as $eselon)
                                <option value="{{ $eselon->id }}" {{ old('eselon_id') == $eselon->id ? 'selected' : '' }}>
                                    {{ $eselon->nama_eselon }}
                                </option>
                                @endforeach
                            </select>
                        </p>
                        <p class="form-group">
                            <label for="pendidikan_id">Pendidikan:</label>
                            <select name="pendidikan_id" id="pendidikan_id">
                                <option value="">Pilih Pendidikan</option>
                                @foreach ($pendidikans as $pendidikan)
                                <option value="{{ $pendidikan->id }}" {{ old('pendidikan_id') == $pendidikan->id ? 'selected' : '' }}>
                                    {{ $pendidikan->nama_pendidikan }}
                                </option>
                                @endforeach
                            </select>
                        </p>
                        <p class="form-group">
                            <label for="status_pegawai">Status Pegawai:</label>
                            <select name="status_pegawai" id="status_pegawai">
                                <option value="">Pilih</option>
                                <option value="Aktif" {{ old('status_pegawai') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-aktif" {{ old('status_pegawai') == 'Non-aktif' ? 'selected' : '' }}>Pindah</option>
                                <option value="Pensiun" {{ old('status_pegawai') == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                            </select>
                        </p>
                        <p class="form-group">
                            <label for="tmt_status">TMT Status:</label>
                            <input type="date" name="tmt_status" id="tmt_status" value="{{ old('tmt_status') }}">
                        </p>
                        <p class="form-group">
                            <label for="unit_kerja_id">Bidang:</label>
                            <select name="unit_kerja_id" id="unit_kerja_id">
                                <option value="">Pilih Bidang</option>
                                @foreach ($unitKerjaList as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_kerja_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                                @endforeach
                            </select>
                        </p>
                        {{-- PERBAIKAN: Input tanggal berkala dan KP di modal tambah kini konsisten dengan form lainnya --}}
                        <p class="form-group">
                            <label for="tgl_usulan_berkala_awal">Tanggal Usulan Berkala Awal:</label>
                            <input type="date" name="tgl_usulan_berkala_awal" id="tgl_usulan_berkala_awal" value="{{ old('tgl_usulan_berkala_awal') }}">
                        </p>
                        <p class="form-group">
                            <label for="tgl_usulan_kp_awal">Tanggal Usulan KP Awal:</label>
                            <input type="date" name="tgl_usulan_kp_awal" id="tgl_usulan_kp_awal" value="{{ old('tgl_usulan_kp_awal') }}">
                        </p>
                    </div>
                    <p class="form-group">
                        <label for="alamat">Alamat:</label>
                        <textarea name="alamat" id="alamat">{{ old('alamat') }}</textarea>
                    </p>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Pegawai</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Pegawai --}}
<div class="modal fade" id="editPegawaiModal" tabindex="-1" aria-labelledby="editPegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPegawaiModalLabel">Edit Data Pegawai</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPegawaiForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_redirect_to" value="{{ request()->fullUrl() }}">

                    

                        <div class="form-group text-center mb-4">
                            <label for="modal_edit_foto_profil" class="d-block mb-2">Foto Profil:</label>
                            <div class="profile-photo-upload-container">
                                <img id="modal-edit-profile-preview-image" src="{{ asset('img/no-photo.jpg') }}" alt="No Photo" class="profile-photo-preview">
                                <button type="button" id="modal-edit-upload-new-button" class="btn btn-sm btn-outline-primary upload-button">Upload New</button>
                                <input type="file" name="foto_profil" id="modal_edit_foto_profil" class="d-none">
                            </div>
                            <div class="form-check d-flex justify-content-center align-items-center mt-2">
                                <input class="form-check-input me-1" type="checkbox" name="hapus_foto_profil" value="1" id="modal_edit_hapus_foto_profil">
                                <label class="form-check-label" for="modal_edit_hapus_foto_profil">
                                    Hapus Foto Profil Saat Ini
                                </label>
                            </div>
                            @error('foto_profil')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="modal_edit_nip" class="form-label">NIP:</label>
                            <input type="text" name="nip" id="modal_edit_nip" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_nik" class="form-label">NIK:</label>
                            <input type="text" name="nik" id="modal_edit_nik" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_nama_lengkap" class="form-label">Nama Lengkap:</label>
                            <input type="text" name="nama_lengkap" id="modal_edit_nama_lengkap" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                            <input type="date" name="tanggal_lahir" id="modal_edit_tanggal_lahir" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="modal_edit_jenis_kelamin" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_email" class="form-label">Email:</label>
                            <input type="email" name="email" id="modal_edit_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_nomor_telepon" class="form-label">Nomor Telepon:</label>
                            <input type="text" name="nomor_telepon" id="modal_edit_nomor_telepon" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_jabatan" class="form-label">Jabatan:</label>
                            <input type="text" name="jabatan" id="modal_edit_jabatan" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_golongan_id" class="form-label">Golongan:</label>
                            <select name="golongan_id" id="modal_edit_golongan_id" class="form-select">
                                <option value="">Pilih Golongan</option>
                                @foreach ($golongans as $golongan)
                                <option value="{{ $golongan->id }}">{{ $golongan->nama_golongan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_tmt" class="form-label">TMT Golongan:</label>
                            <input type="date" name="tmt" id="modal_edit_tmt" class="form-control">
                            <div id="edit-tmt-error" class="text-danger text-sm mt-1"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_eselon_id" class="form-label">Eselon:</label>
                            <select name="eselon_id" id="modal_edit_eselon_id" class="form-select">
                                <option value="">Pilih Eselon</option>
                                @foreach ($eselons as $eselon)
                                <option value="{{ $eselon->id }}">{{ $eselon->nama_eselon }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_pendidikan_id" class="form-label">Pendidikan:</label>
                            <select name="pendidikan_id" id="modal_edit_pendidikan_id" class="form-select">
                                <option value="">Pilih Pendidikan</option>
                                @foreach ($pendidikans as $pendidikan)
                                <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_status_pegawai" class="form-label">Status Pegawai:</label>
                            <select name="status_pegawai" id="modal_edit_status_pegawai" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-aktif">Pindah</option>
                                <option value="Pensiun">Pensiun</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_tmt_status" class="form-label">TMT Status:</label>
                            <input type="date" name="tmt_status" id="modal_edit_tmt_status" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_unit_kerja_id" class="form-label">Bidang:</label>
                            <select name="unit_kerja_id" id="modal_edit_unit_kerja_id" class="form-select">
                                <option value="">Pilih Bidang</option>
                                @foreach ($unitKerjaList as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- BARU: Menambahkan field input tanggal berkala dan KP ke modal edit --}}
                        <div class="col-md-6">
                            <label for="modal_edit_tgl_usulan_berkala_awal" class="form-label">Tgl Usulan Berkala Awal:</label>
                            <input type="date" name="tgl_usulan_berkala_awal" id="modal_edit_tgl_usulan_berkala_awal" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="modal_edit_tgl_usulan_kp_awal" class="form-label">Tgl Usulan KP Awal:</label>
                            <input type="date" name="tgl_usulan_kp_awal" id="modal_edit_tgl_usulan_kp_awal" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="modal_edit_alamat" class="form-label">Alamat:</label>
                            <textarea name="alamat" id="modal_edit_alamat" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="submit" class="btn btn-primary">Perbarui Pegawai</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts') {{-- For page-specific JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script untuk modal delete
        const confirmDeleteModalElement = document.getElementById('confirmDeleteModal');
        const formDelete = document.getElementById('formDelete');
        const namaPegawaiSpan = document.getElementById('namaPegawai');

        if (confirmDeleteModalElement) {
            confirmDeleteModalElement.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const nama = button.getAttribute('data-nama');
                const action = button.getAttribute('data-action');

                namaPegawaiSpan.textContent = nama;
                formDelete.setAttribute('action', action);
            });
        }

        // Script untuk modal export options
        const exportOptionsModalElement = document.getElementById('exportOptionsModal');
        if (exportOptionsModalElement) {
            exportOptionsModalElement.addEventListener('show.bs.modal', function(event) {
                const exportForm = document.getElementById('exportForm');
                exportForm.reset();

                const currentSearchTerm = new URLSearchParams(window.location.search).get('search');
                const currentUnitFilter = new URLSearchParams(window.location.search).get('unit_kerja');
                const currentStatusFilter = new URLSearchParams(window.location.search).get('status_pegawai');

                if (currentUnitFilter) {
                    document.getElementById('unit_kerja_filter_modal').value = currentUnitFilter;
                }
                if (currentStatusFilter) {
                    document.getElementById('status_filter').value = currentStatusFilter;
                }

                const defaultColumns = ['nip', 'nama_lengkap', 'nomor_telepon', 'unit_kerja.nama_unit', 'jabatan', 'status_pegawai', 'alamat'];
                exportForm.querySelectorAll('input[name="columns[]"]').forEach(checkbox => {
                    if (defaultColumns.includes(checkbox.value)) {
                        checkbox.checked = true;
                    } else {
                        checkbox.checked = false;
                    }
                });
            });
        }

        // Script untuk Modal Tambah Pegawai
        const tambahPegawaiModalElement = document.getElementById('tambahPegawaiModal');
        const addFileInput = document.getElementById('foto_profil');
        const addPreviewImage = document.getElementById('profile-preview-image');
        const addUploadButton = document.getElementById('upload-new-button');

        if (tambahPegawaiModalElement && addFileInput && addPreviewImage && addUploadButton) {
            addUploadButton.addEventListener('click', function() {
                addFileInput.click();
            });

            addFileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        addPreviewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    addPreviewImage.src = "{{ asset('img/no-photo.jpg') }}";
                }
            });

            tambahPegawaiModalElement.addEventListener('hidden.bs.modal', function() {
                addPreviewImage.src = "{{ asset('img/no-photo.jpg') }}";
                addFileInput.value = '';
            });

            // Perbaikan syntax error pada blade di sini
            @if($errors->any() && session('modal_target') == 'tambahPegawaiModal')
            var tambahModal = new bootstrap.Modal(document.getElementById('tambahPegawaiModal'));
            tambahModal.show();
            @endif
        }


        // Script untuk Modal Edit Pegawai
        const editPegawaiModal = document.getElementById('editPegawaiModal');
        if (editPegawaiModal) {
            const editFileInput = document.getElementById('modal_edit_foto_profil');
            const editPreviewImage = document.getElementById('modal-edit-profile-preview-image');
            const editUploadButton = document.getElementById('modal-edit-upload-new-button');
            const editHapusFotoProfilCheckbox = document.getElementById('modal_edit_hapus_foto_profil');

            editPegawaiModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nip = button.getAttribute('data-nip');
                const nik = button.getAttribute('data-nik');
                const namaLengkap = button.getAttribute('data-nama-lengkap');
                const tanggalLahir = button.getAttribute('data-tanggal-lahir');
                const jenisKelamin = button.getAttribute('data-jenis-kelamin');
                const alamat = button.getAttribute('data-alamat');
                const email = button.getAttribute('data-email');
                const nomorTelepon = button.getAttribute('data-nomor-telepon');
                const jabatan = button.getAttribute('data-jabatan');
                const golonganId = button.getAttribute('data-golongan-id');
                const eselonId = button.getAttribute('data-eselon-id');
                const pendidikanId = button.getAttribute('data-pendidikan-id');
                const tmt = button.getAttribute('data-tmt');
                const tmtStatus = button.getAttribute('data-tmt-status');
                const unitKerjaId = button.getAttribute('data-unit-kerja-id');
                const statusPegawai = button.getAttribute('data-status-pegawai');
                const fotoProfilPath = button.getAttribute('data-foto-profil-path');
                
                // BARU: Mengambil data tanggal berkala dan KP dari atribut data tombol
                const tglUsulanBerkalaAwal = button.getAttribute('data-tgl-usulan-berkala-awal');
                const tglUsulanKpAwal = button.getAttribute('data-tgl-usulan-kp-awal');

                const modalTitle = editPegawaiModal.querySelector('.modal-title');
                const form = editPegawaiModal.querySelector('#editPegawaiForm');

                modalTitle.textContent = `Edit Data Pegawai: ${namaLengkap}`;
                form.action = `/pegawai/${id}`;

                // Mengisi semua field form di modal edit
                editPegawaiModal.querySelector('#modal_edit_nip').value = nip;
                editPegawaiModal.querySelector('#modal_edit_nik').value = nik;
                editPegawaiModal.querySelector('#modal_edit_nama_lengkap').value = namaLengkap;
                editPegawaiModal.querySelector('#modal_edit_tanggal_lahir').value = tanggalLahir;
                editPegawaiModal.querySelector('#modal_edit_jenis_kelamin').value = jenisKelamin;
                editPegawaiModal.querySelector('#modal_edit_alamat').value = alamat;
                editPegawaiModal.querySelector('#modal_edit_email').value = email;
                editPegawaiModal.querySelector('#modal_edit_nomor_telepon').value = nomorTelepon;
                editPegawaiModal.querySelector('#modal_edit_tmt').value = tmt;
                editPegawaiModal.querySelector('#modal_edit_jabatan').value = jabatan;
                editPegawaiModal.querySelector('#modal_edit_eselon_id').value = eselonId;
                editPegawaiModal.querySelector('#modal_edit_golongan_id').value = golonganId;
                editPegawaiModal.querySelector('#modal_edit_pendidikan_id').value = pendidikanId;
                editPegawaiModal.querySelector('#modal_edit_unit_kerja_id').value = unitKerjaId;
                editPegawaiModal.querySelector('#modal_edit_status_pegawai').value = statusPegawai;
                editPegawaiModal.querySelector('#modal_edit_tmt_status').value = tmtStatus;

                // BARU: Mengisi field tanggal berkala dan KP dengan data yang diambil
                editPegawaiModal.querySelector('#modal_edit_tgl_usulan_berkala_awal').value = tglUsulanBerkalaAwal;
                editPegawaiModal.querySelector('#modal_edit_tgl_usulan_kp_awal').value = tglUsulanKpAwal;
                
                // Menangani preview foto profil
                if (fotoProfilPath && fotoProfilPath.indexOf('no-photo.jpg') === -1 && fotoProfilPath.indexOf('pria.jpg') === -1 && fotoProfilPath.indexOf('wanita.jpg') === -1) {
                    editPreviewImage.src = fotoProfilPath;
                    editPreviewImage.dataset.originalSrc = fotoProfilPath;
                } else {
                    const defaultGenderPhoto = (jenisKelamin === 'Perempuan') ? '{{ asset('img/wanita.jpg') }}' : '{{ asset('img/pria.jpg') }}';
                    editPreviewImage.src = defaultGenderPhoto;
                    editPreviewImage.dataset.originalSrc = defaultGenderPhoto;
                }
                editHapusFotoProfilCheckbox.checked = false;
                editFileInput.value = '';
            });

            // Event listener untuk tombol 'Unggah Baru' di modal edit
            editUploadButton.addEventListener('click', function() {
                editFileInput.click();
            });

            // Event listener saat file baru dipilih
            editFileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        editPreviewImage.src = e.target.result;
                        if (editHapusFotoProfilCheckbox) {
                            editHapusFotoProfilCheckbox.checked = false;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Event listener untuk checkbox 'Hapus Foto Profil'
            if (editHapusFotoProfilCheckbox) {
                editHapusFotoProfilCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        editPreviewImage.src = "{{ asset('img/no-photo.jpg') }}";
                        editFileInput.value = '';
                    } else {
                        editPreviewImage.src = editPreviewImage.dataset.originalSrc || "{{ asset('img/no-photo.jpg') }}";
                    }
                });
            }

            // Reset modal saat ditutup
            editPegawaiModal.addEventListener('hidden.bs.modal', function() {
                editPreviewImage.src = "{{ asset('img/no-photo.jpg') }}";
                editFileInput.value = '';
                if (editHapusFotoProfilCheckbox) {
                    editHapusFotoProfilCheckbox.checked = false;
                }
            });

            // Perbaikan syntax error pada blade di sini
            @if($errors->any() && session('modal_target') == 'editPegawaiModal')
            var editModal = new bootstrap.Modal(document.getElementById('editPegawaiModal'));
            editModal.show();
            @endif
        }
    });
</script>
@endsection
