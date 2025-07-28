@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')

    <div class="stats-container">
        <div class="stat-card">
            <div class="icon-wrapper total">
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
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#d39e00" class="bi bi-person-x-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.854 10.146a.5.5 0 0 1 0-.708L13.293 8l-1.439-1.439a.5.5 0 1 1 .708-.708l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0z"/>
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
            </div>
            <div class="stat-info">
                <p class="stat-label">Pindah</p>
                <p class="stat-value">{{ $pegawaiNonAktif ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper retired">
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
        <p>
            <button type="button" class="btn-tambah" data-bs-toggle="modal" data-bs-target="#addPegawaiModal"> + Tambah Pegawai Baru</button>
            <button type="button" class="btn-tambah" style="border: none; background-color: #28a745;" data-bs-toggle="modal" data-bs-target="#exportOptionsModal">
                Export Excel
            </button>
        </p>
    </div>

    {{-- Form Pencarian --}}
    <form class="form-pencarian" method="GET" action="{{ route('pegawai.index') }}" >
        <input type="text" name="search" placeholder="Cari NIP, Nama, Jabatan, Unit Kerja..." value="{{ $searchTerm ?? '' }}" >
        <button type="submit">Cari</button>
        @if ($searchTerm ?? '')
            <a href="{{ route('pegawai.index') }}" class="btn-reset-pencarian">Reset Pencarian</a>
        @endif
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

            <div class="status" style="height: 44px; " >
                <select class="filter" name="status_pegawai">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ (isset($statusFilter) && $statusFilter == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-aktif" {{ (isset($statusFilter) && $statusFilter == 'Non-aktif') ? 'selected' : '' }}>Non-aktif</option>
                    <option value="Pensiun" {{ (isset($statusFilter) && $statusFilter == 'Pensiun') ? 'selected' : '' }}>Pensiun</option>
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
                            <img src="{{ asset($p->foto_profil_path) }}" alt="Foto Profil {{ $p->nama_lengkap }}">
                        @else
                            <img src="{{ asset('img/' . ($p->jenis_kelamin == 'Perempuan' ? 'wanita.jpg' : 'pria.jpg')) }}" alt="Foto Profil Default">
                        @endif
                    </td>
                    <td>{{ $p->nip }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->jabatan ?? '-' }}</td>
                    <td>{{ $p->unit_kerja->nama_unit ?? '-' }}</td>
                    <td style="white-space: nowrap;"> {{-- Tambahkan style untuk mencegah baris terpotong --}}
                        @php
                            $statusClass = '';
                            if ($p->status_pegawai == 'Aktif') {
                                $statusClass = 'aktif';
                            } elseif ($p->status_pegawai == 'Non-aktif') {
                                $statusClass = 'non-aktif';
                            } elseif ($p->status_pegawai == 'Pensiun') {
                                $statusClass = 'pensiun';
                            }

                            // Format tanggal TMT jika ada
                            $tmtFormatted = $p->tmt_status ? \Carbon\Carbon::parse($p->tmt_status)->format('d-m-Y') : 'N/A';
                            // Jika Anda ingin TMT dari 'tmt' (Tanggal Mulai Terhitung) bukan 'tmt_status'
                            // $tmtFormatted = $p->tmt ? \Carbon\Carbon::parse($p->tmt)->format('d-m-Y') : 'N/A';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $p->status_pegawai == 'Non-aktif' ? 'Pindah' : $p->status_pegawai }}
                        </span>
                        {{-- Tambahkan baris baru untuk TMT Status --}}
                        <br>
                        <small class="text-muted" style="font-size: 0.8em;">TMT: {{ $tmtFormatted }}</small>
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
                        <a href="#" class="btn-aksi btn-edit edit-pegawai-btn" title="Edit"
                           data-bs-toggle="modal" data-bs-target="#editPegawaiModal"
                           data-id="{{ $p->id }}"
                           data-nip="{{ $p->nip }}"
                           data-nik="{{ $p->nik }}"
                           data-nama_lengkap="{{ $p->nama_lengkap }}"
                           data-tanggal_lahir="{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('Y-m-d') : '' }}"
                           data-tmt="{{ $p->tmt ? \Carbon\Carbon::parse($p->tmt)->format('Y-m-d') : '' }}"
                           data-jenis_kelamin="{{ $p->jenis_kelamin }}"
                           data-email="{{ $p->email }}"
                           data-nomor_telepon="{{ $p->nomor_telepon }}"
                           data-jabatan="{{ $p->jabatan }}"
                           data-golongan_id="{{ $p->golongan_id }}"
                           data-eselon_id="{{ $p->eselon_id }}"
                           data-pendidikan_id="{{ $p->pendidikan_id }}"
                           data-unit_kerja_id="{{ $p->unit_kerja_id }}"
                           data-status_pegawai="{{ $p->status_pegawai }}"
                           data-alamat="{{ $p->alamat }}"
                           data-foto_profil_path="{{ $p->foto_profil_path ? asset($p->foto_profil_path) : 'https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo' }}">
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

    {{-- BARU: Modal untuk Export dengan Opsi (tetap di sini) --}}
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
                                    'unit_kerja.nama_unit' => 'Unit Kerja',
                                    'jabatan' => 'Jabatan',
                                    'golongan_pangkat' => 'Pangkat', // Assuming this comes from a relation or property
                                    'status_pegawai' => 'Status',
                                    'alamat' => 'Alamat',
                                    'tanggal_lahir' => 'Tanggal Lahir',
                                    'jenis_kelamin' => 'Jenis Kelamin',
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
                                <option value="all">Semua Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-aktif">Non-aktif</option>
                                <option value="Pensiun">Pensiun</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="unit_kerja_filter_modal" class="form-label">Unit Kerja:</label>
                            <select class="form-select" id="unit_kerja_filter_modal" name="unit_kerja_filter">
                                <option value="">Semua Unit Kerja</option>
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


    {{-- NEW: MODAL UNTUK EDIT PEGAWAI --}}
    <div class="modal fade" id="editPegawaiModal" tabindex="-1" aria-labelledby="editPegawaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> {{-- Use modal-lg for a larger modal to fit the form --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPegawaiModalLabel">Edit Data Pegawai: <span id="pegawaiNamaModal"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPegawaiForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        {{-- Hidden field to redirect back to index --}}
                        <input type="hidden" name="_redirect_to" value="{{ route('pegawai.index') }}">

                        {{-- Foto Profil Section --}}

                        {{-- Foto Profil Section --}}
<div class="d-flex flex-column align-items-center mb-5">
    <div class="relative w-32 h-32 overflow-hidden border-1 border-white-600 shadow-md rounded-full" style="width: 128px; height: 128px;">
        <img id="edit-profile-preview-image"
            src="https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo" {{-- Default placeholder --}}
            alt="Foto Profil"
            class="w-full h-full object-cover"
            style="max-width: 150px; max-height: 150px; width: auto; height: auto;">
        {{-- Input file ini akan disembunyikan dan dipicu oleh tombol "Upload New" --}}
        <input type="file" name="foto_profil" id="edit_foto_profil" class="hidden" accept="image/*">
    </div>
    <div class="d-flex mt-2 justify-content-center align-items-center" style="gap: 8px; width: 100%;">
        <button type="button" id="edit-upload-new-button" class="btn btn-primary btn-sm">Upload New</button>
        <label for="edit_hapus_foto_profil" class="btn btn-warning btn-sm cursor-pointer mb-0">
            <input type="checkbox" name="hapus_foto_profil" value="1" id="edit_hapus_foto_profil" class="form-check-input me-1">
            Delete Avatar
        </label>
    </div>
    {{-- Error handling for foto_profil (will show if form submission fails) --}}
    <div id="edit-foto-profil-error" class="text-danger text-sm mt-1"></div>
</div>


                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nip" class="form-label">NIP:</label>
                                <input type="text" name="nip" id="edit_nip" class="form-control" required>
                                <div id="edit-nip-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_nik" class="form-label">NIK:</label>
                                <input type="text" name="nik" id="edit_nik" class="form-control">
                                <div id="edit-nik-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_lengkap" class="form-label">Nama Lengkap:</label>
                                <input type="text" name="nama_lengkap" id="edit_nama_lengkap" class="form-control" required>
                                <div id="edit-nama_lengkap-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                                <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="form-control">
                                <div id="edit-tanggal_lahir-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tmt" class="form-label">TMT (Tanggal Mulai Terhitung):</label>
                                <input type="date" name="tmt" id="edit_tmt" class="form-control">
                                <div id="edit-tmt-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="edit_jenis_kelamin_laki" value="Laki-laki">
                                    <label class="form-check-label" for="edit_jenis_kelamin_laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="edit_jenis_kelamin_perempuan" value="Perempuan">
                                    <label class="form-check-label" for="edit_jenis_kelamin_perempuan">Perempuan</label>
                                </div>
                                <div id="edit-jenis_kelamin-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_email" class="form-label">Email:</label>
                                <input type="email" name="email" id="edit_email" class="form-control">
                                <div id="edit-email-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_nomor_telepon" class="form-label">Nomor Telepon:</label>
                                <input type="text" name="nomor_telepon" id="edit_nomor_telepon" class="form-control">
                                <div id="edit-nomor_telepon-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_jabatan" class="form-label">Jabatan:</label>
                                <input type="text" name="jabatan" id="edit_jabatan" class="form-control">
                                <div id="edit-jabatan-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_golongan_id" class="form-label">Golongan:</label>
                                <select name="golongan_id" id="edit_golongan_id" class="form-select">
                                    <option value="">Pilih Golongan</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}">{{ $golongan->nama_golongan }}</option>
                                    @endforeach
                                </select>
                                <div id="edit-golongan_id-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_eselon_id" class="form-label">Eselon:</label>
                                <select name="eselon_id" id="edit_eselon_id" class="form-select">
                                    <option value="">Pilih Eselon</option>
                                    @foreach ($eselons as $eselon)
                                        <option value="{{ $eselon->id }}">{{ $eselon->nama_eselon }}</option>
                                    @endforeach
                                </select>
                                <div id="edit-eselon_id-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_pendidikan_id" class="form-label">Pendidikan:</label>
                                <select name="pendidikan_id" id="edit_pendidikan_id" class="form-select">
                                    <option value="">Pilih Pendidikan</option>
                                    @foreach ($pendidikans as $pendidikan)
                                        <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
                                    @endforeach
                                </select>
                                <div id="edit-pendidikan_id-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_unit_kerja_id" class="form-label">Unit Kerja:</label>
                                <select name="unit_kerja_id" id="edit_unit_kerja_id" class="form-select">
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($unitKerjaList as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                    @endforeach
                                </select>
                                <div id="edit-unit_kerja_id-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_status_pegawai" class="form-label">Status Pegawai:</label>
                                <select name="status_pegawai" id="edit_status_pegawai" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non-aktif">Non-aktif</option>
                                    <option value="Pensiun">Pensiun</option>
                                </select>
                                <div id="edit-status_pegawai-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat:</label>
                            <textarea name="alamat" id="edit_alamat" rows="3" class="form-control"></textarea>
                            <div id="edit-alamat-error" class="text-danger text-sm mt-1"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui Data Pegawai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- NEW: MODAL UNTUK TAMBAH PEGAWAI --}}
    <div class="modal fade" id="addPegawaiModal" tabindex="-1" aria-labelledby="addPegawaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> {{-- Use modal-lg for a larger modal to fit the form --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPegawaiModalLabel">Tambah Pegawai Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPegawaiForm" method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        {{-- Hidden field to redirect back to index (optional, useful for non-AJAX submission) --}}
                        <input type="hidden" name="_redirect_to" value="{{ route('pegawai.index') }}">

                        {{-- Foto Profil Section for Add Modal (similar to Edit Modal but without existing path) --}}
                        <div class="d-flex flex-column align-items-center mb-5">
                            <div class="relative w-32 h-32 overflow-hidden border-1 border-white-600 shadow-md rounded-full" style="width: 128px; height: 128px;">
                                <img id="add-profile-preview-image"
                                    src="https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo" {{-- Default placeholder --}}
                                    alt="Foto Profil"
                                    class="w-full h-full object-cover"
                                    style="max-width: 150px; max-height: 150px; width: auto; height: auto;">
                                <input type="file" name="foto_profil" id="add_foto_profil" class="hidden" accept="image/*">
                            </div>
                            <div class="d-flex mt-2 justify-content-center align-items-center" style="gap: 8px; width: 100%;">
                                <button type="button" id="add-upload-new-button" class="btn btn-primary btn-sm">Upload New</button>
                                {{-- For Add Modal, usually no "Delete Avatar" checkbox, as there's no existing avatar to delete --}}
                                {{-- If you want to allow users to remove a newly selected photo before saving, you can add a similar checkbox --}}
                            </div>
                            <div id="add-foto-profil-error" class="text-danger text-sm mt-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_nip" class="form-label">NIP <span class="text-danger">*</span>:</label>
                                <input type="text" name="nip" id="add_nip" class="form-control" value="{{ old('nip') }}" required>
                                <div id="add-nip-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="add_nik" class="form-label">NIK:</label>
                                <input type="text" name="nik" id="add_nik" class="form-control" value="{{ old('nik') }}">
                                <div id="add-nik-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span>:</label>
                                <input type="text" name="nama_lengkap" id="add_nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                                <div id="add-nama_lengkap-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="add_tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                                <input type="date" name="tanggal_lahir" id="add_tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                                <div id="add-tanggal_lahir-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_tmt" class="form-label">TMT (Tanggal Mulai Terhitung):</label>
                                <input type="date" name="tmt" id="add_tmt" class="form-control" value="{{ old('tmt') }}">
                                <div id="add-tmt-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="add_jenis_kelamin_laki" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="add_jenis_kelamin_laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="add_jenis_kelamin_perempuan" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="add_jenis_kelamin_perempuan">Perempuan</label>
                                </div>
                                <div id="add-jenis_kelamin-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_email" class="form-label">Email:</label>
                                <input type="email" name="email" id="add_email" class="form-control" value="{{ old('email') }}">
                                <div id="add-email-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="add_nomor_telepon" class="form-label">Nomor Telepon:</label>
                                <input type="text" name="nomor_telepon" id="add_nomor_telepon" class="form-control" value="{{ old('nomor_telepon') }}">
                                <div id="add-nomor_telepon-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_jabatan" class="form-label">Jabatan:</label>
                                <input type="text" name="jabatan" id="add_jabatan" class="form-control" value="{{ old('jabatan') }}">
                                <div id="add-jabatan-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="add_golongan_id" class="form-label">Golongan:</label>
                                <select name="golongan_id" id="add_golongan_id" class="form-select">
                                    <option value="">Pilih Golongan</option>
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}" {{ old('golongan_id') == $golongan->id ? 'selected' : '' }}>{{ $golongan->nama_golongan }}</option>
                                    @endforeach
                                </select>
                                <div id="add-golongan_id-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_eselon_id" class="form-label">Eselon:</label>
                                <select name="eselon_id" id="add_eselon_id" class="form-select">
                                    <option value="">Pilih Eselon</option>
                                    @foreach ($eselons as $eselon)
                                        <option value="{{ $eselon->id }}" {{ old('eselon_id') == $eselon->id ? 'selected' : '' }}>{{ $eselon->nama_eselon }}</option>
                                    @endforeach
                                </select>
                                <div id="add-eselon_id-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="add_pendidikan_id" class="form-label">Pendidikan:</label>
                                <select name="pendidikan_id" id="add_pendidikan_id" class="form-select">
                                    <option value="">Pilih Pendidikan</option>
                                    @foreach ($pendidikans as $pendidikan)
                                        <option value="{{ $pendidikan->id }}" {{ old('pendidikan_id') == $pendidikan->id ? 'selected' : '' }}>{{ $pendidikan->nama_pendidikan }}</option>
                                    @endforeach
                                </select>
                                <div id="add-pendidikan_id-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_unit_kerja_id" class="form-label">Unit Kerja:</label>
                                <select name="unit_kerja_id" id="add_unit_kerja_id" class="form-select">
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($unitKerjaList as $unit) {{-- Use $unitKerjaList, not $unit_kerja --}}
                                        <option value="{{ $unit->id }}" {{ old('unit_kerja_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                                    @endforeach
                                </select>
                                <div id="add-unit_kerja_id-error" class="text-danger text-sm mt-1"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="add_status_pegawai" class="form-label">Status Pegawai:</label>
                                <select name="status_pegawai" id="add_status_pegawai" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Aktif" {{ old('status_pegawai') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Non-aktif" {{ old('status_pegawai') == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                                    <option value="Pensiun" {{ old('status_pegawai') == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                                </select>
                                <div id="add-status_pegawai-error" class="text-danger text-sm mt-1"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="add_tmt_status" class="form-label">TMT Status:</label>
                            <input type="date" name="tmt_status" id="add_tmt_status" class="form-control" value="{{ old('tmt_status') }}">
                            <div id="add-tmt_status-error" class="text-danger text-sm mt-1"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="add_alamat" class="form-label">Alamat:</label>
                            <textarea name="alamat" id="add_alamat" rows="3" class="form-control">{{ old('alamat') }}</textarea>
                            <div id="add-alamat-error" class="text-danger text-sm mt-1"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Pegawai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... (Existing Export Modal Script) ...

        // --- NEW: Add Pegawai Modal Script ---
        var addPegawaiModal = document.getElementById('addPegawaiModal');
        var addPegawaiForm = document.getElementById('addPegawaiForm');
        var addProfilePreviewImage = document.getElementById('add-profile-preview-image');
        var addFotoProfilInput = document.getElementById('add_foto_profil');
        var addUploadNewButton = document.getElementById('add-upload-new-button');
        
        // Reset form dan preview gambar saat modal Add dibuka
        addPegawaiModal.addEventListener('show.bs.modal', function (event) {
            addPegawaiForm.reset(); // Reset semua input form
            addProfilePreviewImage.src = 'https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo'; // Reset gambar preview
            // Clear previous validation errors if any (important if validation fails and modal is reopened)
            document.querySelectorAll('#addPegawaiForm .text-danger').forEach(function(element) {
                element.textContent = '';
            });
            document.querySelectorAll('#addPegawaiForm .form-control.is-invalid, #addPegawaiForm .form-select.is-invalid').forEach(function(element) {
                element.classList.remove('is-invalid');
            });
        });

        // Handle file input change for image preview in Add modal
        if (addFotoProfilInput) {
            addFotoProfilInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        addProfilePreviewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    addProfilePreviewImage.src = 'https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo'; // Revert to default if no file selected
                }
            });
        }

        // Trigger the hidden file input when "Upload New" button is clicked in Add modal
        if (addUploadNewButton) {
            addUploadNewButton.addEventListener('click', function() {
                addFotoProfilInput.click();
            });
        }

        // --- Existing Edit Pegawai Modal Script (adjust IDs as needed, they seem fine) ---
        var editPegawaiModal = document.getElementById('editPegawaiModal');
        var editPegawaiForm = document.getElementById('editPegawaiForm');
        var pegawaiNamaModal = document.getElementById('pegawaiNamaModal');
        var editProfilePreviewImage = document.getElementById('edit-profile-preview-image');
        var editFotoProfilInput = document.getElementById('edit_foto_profil');
        var editUploadNewButton = document.getElementById('edit-upload-new-button');
        var editHapusFotoProfilCheckbox = document.getElementById('edit_hapus_foto_profil');
        var originalEditProfileSrc = editProfilePreviewImage.src; // Store the original placeholder

        editPegawaiModal.addEventListener('show.bs.modal', function (event) {
            // ... (Existing code for populating edit form fields) ...

            // Handle photo preview and delete checkbox for EDIT MODAL
            editProfilePreviewImage.src = foto_profil_path;
            originalEditProfileSrc = foto_profil_path; // Update original source to the current photo
            editHapusFotoProfilCheckbox.checked = false; // Uncheck delete on modal open
            editFotoProfilInput.value = ''; // Clear file input
            // Hide delete label if no photo exists
            if (foto_profil_path === 'https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo') {
                editHapusFotoProfilCheckbox.closest('label').style.display = 'none';
            } else {
                editHapusFotoProfilCheckbox.closest('label').style.display = 'inline-flex';
            }

            // Clear previous validation errors if any
            document.querySelectorAll('#editPegawaiForm .text-danger').forEach(function(element) {
                element.textContent = '';
            });
            document.querySelectorAll('#editPegawaiForm .form-control.is-invalid, #editPegawaiForm .form-select.is-invalid').forEach(function(element) {
                element.classList.remove('is-invalid');
            });
        });

        // Handle file input change for image preview in EDIT modal
        if (editFotoProfilInput) {
            editFotoProfilInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        editProfilePreviewImage.src = e.target.result;
                        editHapusFotoProfilCheckbox.checked = false; // Uncheck "Delete avatar" if a new photo is uploaded
                        editHapusFotoProfilCheckbox.closest('label').style.display = 'inline-flex'; // Ensure delete option is visible
                    };
                    reader.readAsDataURL(file);
                } else {
                    editProfilePreviewImage.src = originalEditProfileSrc; // Revert to original if no file selected
                }
            });
        }

        // Trigger the hidden file input when "Upload New" button is clicked in EDIT modal
        if (editUploadNewButton) {
            editUploadNewButton.addEventListener('click', function() {
                editFotoProfilInput.click();
            });
        }

        // Handle "Delete avatar" checkbox change in EDIT modal
        if (editHapusFotoProfilCheckbox) {
            editHapusFotoProfilCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    editProfilePreviewImage.src = 'https://placehold.co/128x128/e0e0e0/ffffff?text=No+Photo';
                    editFotoProfilInput.value = ''; // Clear the file input value
                } else {
                    editProfilePreviewImage.src = editFotoProfilInput.files.length > 0 ? URL.createObjectURL(editFotoProfilInput.files[0]) : originalEditProfileSrc;
                }
            });
        }
        
        // ... (Existing AJAX submission example, if you want to implement AJAX for Add/Edit) ...
        // For simple submission, just remove e.preventDefault() and let the form submit normally.
        // If validation fails, Laravel will redirect back with errors.
        // For modals, it's better to use AJAX to show errors within the modal without a full page reload.

        // Example for showing validation errors via AJAX (for both Add and Edit modals)
        // You'd need to modify your controller to return JSON errors for AJAX requests.
        function handleFormSubmission(formId, modalId) {
            const form = document.getElementById(formId);
            form.addEventListener('submit', function(e) {
                // Clear previous errors for this specific form
                document.querySelectorAll(`#${formId} .text-danger`).forEach(function(el) {
                    el.textContent = '';
                });
                document.querySelectorAll(`#${formId} .form-control.is-invalid, #${formId} .form-select.is-invalid`).forEach(function(el) {
                    el.classList.remove('is-invalid');
                });

                e.preventDefault(); // Prevent default form submission for AJAX

                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body }) => {
                    if (status === 422) { // Validation errors
                        const errors = body.errors;
                        for (const field in errors) {
                            // Find the correct element by its ID (either add_field or edit_field)
                            const inputField = document.getElementById(`${formId.startsWith('add') ? 'add_' : 'edit_'}${field}`);
                            if (inputField) {
                                inputField.classList.add('is-invalid');
                                const errorDiv = document.getElementById(`${formId.startsWith('add') ? 'add_' : 'edit_'}${field}-error`);
                                if (errorDiv) {
                                    errorDiv.textContent = errors[field][0];
                                }
                            }
                        }
                    } else if (status >= 200 && status < 300) { // Success
                        // Handle success, e.g., close modal, show success message, refresh table
                        var myModal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                        myModal.hide();
                        // Consider using SweetAlert2 for success/error notifications
                        alert(body.message || 'Data berhasil disimpan!');
                        location.reload(); // Simple reload to see changes
                    } else { // Other errors
                        console.error('Error submitting form:', body);
                        alert(body.message || 'Terjadi kesalahan saat menyimpan data.');
                    }
                })
                .catch(error => {
                    console.error('Network error or unexpected:', error);
                    alert('Terjadi kesalahan jaringan atau tak terduga.');
                });
            });
        }

        // Initialize AJAX submission for both forms
        handleFormSubmission('addPegawaiForm', 'addPegawaiModal');
        handleFormSubmission('editPegawaiForm', 'editPegawaiModal');

        // This is crucial: if you want AJAX to handle form submissions,
        // you need to set up your Laravel controllers to return JSON responses
        // instead of redirecting on success or validation failure.
        // Example in Controller:
        // public function store(Request $request) {
        //     try {
        //         $validatedData = $request->validate([
        //             // ... validation rules ...
        //         ]);
        //         // ... create pegawai ...
        //         return response()->json(['message' => 'Pegawai berhasil ditambahkan!'], 201);
        //     } catch (\Illuminate\Validation\ValidationException $e) {
        //         return response()->json(['errors' => $e->errors()], 422);
        //     } catch (\Exception $e) {
        //         return response()->json(['message' => 'Gagal menambahkan pegawai: ' . $e->getMessage()], 500);
        //     }
        // }
        // Similarly for update method.

    });
</script>
@endsection
