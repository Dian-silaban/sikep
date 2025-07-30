@extends('layouts.app')

@section('content')
<style>
    /* Pastikan CSS ini ada di file CSS yang di-load oleh halaman ini,
   atau tambahkan di dalam tag <style> di bagian atas file Blade ini. */

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem; /* Memberikan sedikit spasi di bawah header */
    padding-bottom: 0.5rem; /* Memberikan padding di bagian bawah jika diperlukan */
    border-bottom: 1px solid #dee2e6; /* Garis pemisah opsional */
}

.table-header h2 {
    margin-bottom: 0; /* Menghilangkan margin bawah default h2 */
    color: #343a40; /* Warna teks gelap */
}




.btn-add-unit {
    /* Gaya tombol agar terlihat seperti tombol, bukan tautan */
    background: linear-gradient(to right, #363d53, #0d3f8b); /* Warna primary Bootstrap */
    color: white;
    text-decoration: none;
    display: inline-flex; /* Agar ikon dan teks sejajar */
    align-items: center; /* Menyelaraskan secara vertikal */
    padding: 0.5rem 1rem;
    font-size: 0.875rem; /* Ukuran font lebih kecil */
    font-weight: 600;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    border-radius: 0.25rem; /* Sudut sedikit melengkung */
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    cursor: pointer;
    
}

.nav-tabs .nav-link.active {
    background-color: #4a90e2; /* Warna latar belakang abu terang */
    color: #fff; /* Warna teks biru Bootstrap primary */
    border-color: #dee2e6 #dee2e6 #e9ecef; /* Membuat border bawah tab aktif menyatu dengan background-color-nya */
}
.nav-tabs .nav-link:not(.active):hover{
    background-color: #376ca9;
    color: #fff;

}
tbody{
    background-color: #fff !important;
}



</style>

<div class="main-container">
    <div class="background-pattern"></div>

    <div class="report-header-section mb-4 d-flex justify-content-between align-items-center">
            {{-- Hapus div 'report-header-content' karena sudah tidak diperlukan untuk layout ini --}}
            {{-- Judul H2 sekarang menjadi direct child dari report-header-section --}}
            <h2 class="report-title text-white mb-0">Manajemen Riwayat untuk {{ $pegawai->nama_lengkap }}</h2> {{-- Tambahkan text-white dan mb-0 --}}
            
            {{-- Tombol Kembali --}}
            {{-- Tombol ini juga menjadi direct child dari report-header-section --}}
            <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-light btn-sm"> {{-- Ganti 'nama.route.index.anda' dengan route yang benar --}}
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
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
                    <div class="table-header"> {{-- Header kustom untuk judul dan tombol tambah, seperti pada "Tambah Jenis Dokumen" --}}
                        <h2>Daftar Riwayat Golongan</h2> {{-- Mengubah h4 menjadi h2 --}}
                        {{-- Tombol "Tambah Riwayat Golongan" yang memicu modal, dengan gaya btn-add-unit --}}
                        <a href="#" class="btn-add-unit" data-bs-toggle="modal" data-bs-target="#addGolonganModal">
                            <i class="fas fa-plus me-2"></i>Tambah Riwayat Golongan
                        </a>
                    </div>
                    @if ($riwayatGolongans->isEmpty())
                    <p class="text-center">Belum ada riwayat golongan untuk pegawai ini.</p>
                    @else
                    <div class="table-responsive table-container">
                        <table class="table-unit-kerja">
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
                                        <button type="button" class="btn-action btn-edit edit-jenis-dokumen" data-bs-toggle="modal" data-bs-target="#editGolonganModal"
                                            data-id="{{ $riwayat->id }}"
                                            data-golongan_id="{{ $riwayat->golongan_id }}"
                                            data-tmt_golongan="{{ $riwayat->tmt_golongan->format('Y-m-d') }}"
                                            data-nomor_sk="{{ $riwayat->nomor_sk }}"
                                            data-tanggal_sk="{{ $riwayat->tanggal_sk ? $riwayat->tanggal_sk->format('Y-m-d') : '' }}"
                                            data-keterangan="{{ $riwayat->keterangan }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('pegawai.riwayat.golongan.destroy', [$pegawai->id, $riwayat->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat golongan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
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
                    <div class="table-header"> {{-- Header kustom untuk judul dan tombol tambah, seperti pada "Tambah Jenis Dokumen" --}}
                        <h2>Daftar Riwayat Jabatan</h2> {{-- Mengubah h4 menjadi h2 --}}
                        {{-- Tombol "Tambah Riwayat Golongan" yang memicu modal, dengan gaya btn-add-unit --}}
                        <a href="#" class="btn-add-unit" data-bs-toggle="modal" data-bs-target="#addGolonganModal">
                            <i class="fas fa-plus me-2"></i>Tambah Riwayat Jabatan
                        </a>
                    </div>
                    @if ($riwayatJabatans->isEmpty())
                    <p class="text-center">Belum ada riwayat jabatan untuk pegawai ini.</p>
                    @else
                    <div class="table-container">
                        <table class="table-unit-kerja">
                            <thead>
                                <tr>
                                    <th>Jabatan</th>
                                    <th>Eselon</th>
                                    <th>Bidang</th>
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
                                        <button type="button" class="btn-action btn-edit edit-jenis-dokumen" data-bs-toggle="modal" data-bs-target="#editJabatanModal"
                                            data-id="{{ $riwayat->id }}"
                                            data-nama_jabatan="{{ $riwayat->nama_jabatan }}"
                                            data-eselon_id="{{ $riwayat->eselon_id }}"
                                            data-unit_kerja_id="{{ $riwayat->unit_kerja_id }}"
                                            data-tmt_jabatan="{{ $riwayat->tmt_jabatan->format('Y-m-d') }}"
                                            data-nomor_sk="{{ $riwayat->nomor_sk }}"
                                            data-tanggal_sk="{{ $riwayat->tanggal_sk ? $riwayat->tanggal_sk->format('Y-m-d') : '' }}"
                                            data-keterangan="{{ $riwayat->keterangan }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('pegawai.riwayat.jabatan.destroy', [$pegawai->id, $riwayat->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat jabatan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
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
                    <div class="table-header"> {{-- Header kustom untuk judul dan tombol tambah, seperti pada "Tambah Jenis Dokumen" --}}
                        <h2>Daftar Riwayat Pendidikan</h2> {{-- Mengubah h4 menjadi h2 --}}
                        {{-- Tombol "Tambah Riwayat Golongan" yang memicu modal, dengan gaya btn-add-unit --}}
                        <a href="#" class="btn-add-unit" data-bs-toggle="modal" data-bs-target="#addGolonganModal">
                            <i class="fas fa-plus me-2"></i>Tambah Riwayat Pendidikan
                        </a>
                    </div>
                    @if ($riwayatPendidikans->isEmpty())
                    <p class="text-center">Belum ada riwayat pendidikan untuk pegawai ini.</p>
                    @else
                    <div class="table-responsive table-container">
                        <table class="table-unit-kerja">
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
                                        <button type="button" class="btn-action btn-edit edit-jenis-dokumen" data-bs-toggle="modal" data-bs-target="#editPendidikanModal"
                                            data-id="{{ $riwayat->id }}"
                                            data-pendidikan_id="{{ $riwayat->pendidikan_id }}"
                                            data-nama_institusi="{{ $riwayat->nama_institusi }}"
                                            data-jurusan="{{ $riwayat->jurusan }}"
                                            data-tahun_lulus="{{ $riwayat->tahun_lulus }}"
                                            data-nomor_ijazah="{{ $riwayat->nomor_ijazah }}"
                                            data-tgl_ijazah="{{ $riwayat->tgl_ijazah ? $riwayat->tgl_ijazah->format('Y-m-d') : '' }}"
                                            data-keterangan="{{ $riwayat->keterangan }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('pegawai.riwayat.pendidikan.destroy', [$pegawai->id, $riwayat->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pendidikan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
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
