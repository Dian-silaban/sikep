@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="background-pattern"></div>

    {{-- Tombol Kembali di kiri atas --}}
    <div class="back-button-container">
        <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
            </svg>
            Kembali ke Detail Pegawai
        </a>
    </div>

    {{-- Container untuk judul --}}
    <div class="page-title-container">
        <h2 class="text-gray-800">Manajemen Riwayat untuk {{ $pegawai->nama_lengkap }}</h2>
    </div>

    <div class="content-wrapper">
        <div class="card">
            <ul class="nav nav-tabs" id="riwayatTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    {{-- PERHATIKAN PERUBAHAN DI SINI: Gunakan $activeTab --}}
                    <button class="nav-link {{ $activeTab == 'golongan' ? 'active' : '' }}" id="golongan-tab" data-bs-toggle="tab" data-bs-target="#golongan" type="button" role="tab" aria-controls="golongan" aria-selected="{{ $activeTab == 'golongan' ? 'true' : 'false' }}">Riwayat Golongan</button>
                </li>
                <li class="nav-item" role="presentation">
                    {{-- PERHATIKAN PERUBAHAN DI SINI: Gunakan $activeTab --}}
                    <button class="nav-link {{ $activeTab == 'jabatan' ? 'active' : '' }}" id="jabatan-tab" data-bs-toggle="tab" data-bs-target="#jabatan" type="button" role="tab" aria-controls="jabatan" aria-selected="{{ $activeTab == 'jabatan' ? 'true' : 'false' }}">Riwayat Jabatan</button>
                </li>
                <li class="nav-item" role="presentation">
                    {{-- PERHATIKAN PERUBAHAN DI SINI: Gunakan $activeTab --}}
                    <button class="nav-link {{ $activeTab == 'pendidikan' ? 'active' : '' }}" id="pendidikan-tab" data-bs-toggle="tab" data-bs-target="#pendidikan" type="button" role="tab" aria-controls="pendidikan" aria-selected="{{ $activeTab == 'pendidikan' ? 'true' : 'false' }}">Riwayat Pendidikan</button>
                </li>
            </ul>
            <div class="tab-content p-3" id="riwayatTabsContent">
                {{-- Tab Riwayat Golongan --}}
                {{-- PERHATIKAN PERUBAHAN DI SINI: Gunakan $activeTab --}}
                <div class="tab-pane fade {{ $activeTab == 'golongan' ? 'show active' : '' }}" id="golongan" role="tabpanel" aria-labelledby="golongan-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Daftar Riwayat Golongan</h4>
                        {{-- Menggunakan route untuk create form di modal --}}
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addGolonganModal">
                            Tambah Riwayat Golongan
                        </button>
                    </div>
                    @if ($riwayatGolongans->isEmpty())
                    <p class="text-center">Belum ada riwayat golongan untuk pegawai ini.</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Golongan</th>
                                    <th>TMT Golongan</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayatGolongans as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->golongan->nama_golongan ?? '-' }}</td>
                                    <td>{{ $riwayat->tmt_golongan->format('d-m-Y') }}</td>
                                    <td>{{ $riwayat->nomor_sk ?? '-' }}</td>
                                    <td>{{ $riwayat->tanggal_sk ? $riwayat->tanggal_sk->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $riwayat->keterangan ?? '-' }}</td>
                                    <td class="action-buttons">
                                        <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editGolonganModal"
                                            data-id="{{ $riwayat->id }}"
                                            data-golongan_id="{{ $riwayat->golongan_id }}"
                                            data-tmt_golongan="{{ $riwayat->tmt_golongan->format('Y-m-d') }}"
                                            data-nomor_sk="{{ $riwayat->nomor_sk }}"
                                            data-tanggal_sk="{{ $riwayat->tanggal_sk ? $riwayat->tanggal_sk->format('Y-m-d') : '' }}"
                                            data-keterangan="{{ $riwayat->keterangan }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('pegawai.riwayat.golongan.destroy', [$pegawai->id, $riwayat->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat golongan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                {{-- Tab Riwayat Jabatan --}}
                {{-- PERHATIKAN PERUBAHAN DI SINI: Gunakan $activeTab --}}
                <div class="tab-pane fade {{ $activeTab == 'jabatan' ? 'show active' : '' }}" id="jabatan" role="tabpanel" aria-labelledby="jabatan-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Daftar Riwayat Jabatan</h4>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addJabatanModal">
                            Tambah Riwayat Jabatan
                        </button>
                    </div>
                    @if ($riwayatJabatans->isEmpty())
                    <p class="text-center">Belum ada riwayat jabatan untuk pegawai ini.</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Jabatan</th>
                                    <th>Eselon</th>
                                    <th>Unit Kerja</th>
                                    <th>TMT Jabatan</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayatJabatans as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->nama_jabatan }}</td>
                                    <td>{{ $riwayat->eselon->nama_eselon ?? '-' }}</td>
                                    <td>{{ $riwayat->unitKerja->nama_unit ?? '-' }}</td>
                                    <td>{{ $riwayat->tmt_jabatan->format('d-m-Y') }}</td>
                                    <td>{{ $riwayat->nomor_sk ?? '-' }}</td>
                                    <td>{{ $riwayat->tanggal_sk ? $riwayat->tanggal_sk->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $riwayat->keterangan ?? '-' }}</td>
                                    <td class="action-buttons">
                                        <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editJabatanModal"
                                            data-id="{{ $riwayat->id }}"
                                            data-nama_jabatan="{{ $riwayat->nama_jabatan }}"
                                            data-eselon_id="{{ $riwayat->eselon_id }}"
                                            data-unit_kerja_id="{{ $riwayat->unit_kerja_id }}"
                                            data-tmt_jabatan="{{ $riwayat->tmt_jabatan->format('Y-m-d') }}"
                                            data-nomor_sk="{{ $riwayat->nomor_sk }}"
                                            data-tanggal_sk="{{ $riwayat->tanggal_sk ? $riwayat->tanggal_sk->format('Y-m-d') : '' }}"
                                            data-keterangan="{{ $riwayat->keterangan }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('pegawai.riwayat.jabatan.destroy', [$pegawai->id, $riwayat->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat jabatan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                {{-- Tab Riwayat Pendidikan --}}
                {{-- PERHATIKAN PERUBAHAN DI SINI: Gunakan $activeTab --}}
                <div class="tab-pane fade {{ $activeTab == 'pendidikan' ? 'show active' : '' }}" id="pendidikan" role="tabpanel" aria-labelledby="pendidikan-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Daftar Riwayat Pendidikan</h4>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPendidikanModal">
                            Tambah Riwayat Pendidikan
                        </button>
                    </div>
                    @if ($riwayatPendidikans->isEmpty())
                    <p class="text-center">Belum ada riwayat pendidikan untuk pegawai ini.</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Pendidikan</th>
                                    <th>Institusi</th>
                                    <th>Jurusan</th>
                                    <th>Tahun Lulus</th>
                                    <th>Nomor Ijazah</th>
                                    <th>Tanggal Ijazah</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayatPendidikans as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->pendidikan->nama_pendidikan ?? '-' }}</td>
                                    <td>{{ $riwayat->nama_institusi }}</td>
                                    <td>{{ $riwayat->jurusan ?? '-' }}</td>
                                    <td>{{ $riwayat->tahun_lulus }}</td>
                                    <td>{{ $riwayat->nomor_ijazah ?? '-' }}</td>
                                    <td>{{ $riwayat->tgl_ijazah ? $riwayat->tgl_ijazah->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $riwayat->keterangan ?? '-' }}</td>
                                    <td class="action-buttons">
                                        <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editPendidikanModal"
                                            data-id="{{ $riwayat->id }}"
                                            data-pendidikan_id="{{ $riwayat->pendidikan_id }}"
                                            data-nama_institusi="{{ $riwayat->nama_institusi }}"
                                            data-jurusan="{{ $riwayat->jurusan }}"
                                            data-tahun_lulus="{{ $riwayat->tahun_lulus }}"
                                            data-nomor_ijazah="{{ $riwayat->nomor_ijazah }}"
                                            data-tgl_ijazah="{{ $riwayat->tgl_ijazah ? $riwayat->tgl_ijazah->format('Y-m-d') : '' }}"
                                            data-keterangan="{{ $riwayat->keterangan }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('pegawai.riwayat.pendidikan.destroy', [$pegawai->id, $riwayat->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pendidikan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('pegawai.riwayat.golongan_modal')
@include('pegawai.riwayat.jabatan_modal')
@include('pegawai.riwayat.pendidikan_modal')
@endsection

{{-- Ini ditaruh di bagian paling bawah file Blade, sebelum @endsection --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const riwayatTabs = document.getElementById('riwayatTabs');
        if (riwayatTabs) {
            riwayatTabs.addEventListener('shown.bs.tab', function (event) {
                // Ambil ID tab baru (e.g., "golongan", "jabatan", "pendidikan")
                const newTabId = event.target.getAttribute('data-bs-target').substring(1);
                // Buat URL baru dengan parameter 'tab'
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('tab', newTabId);
                // Ubah URL di browser tanpa reload halaman
                window.history.pushState({ path: currentUrl.href }, '', currentUrl.href);
            });
        }
    });
</script>
@endpush
