@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar')
    </div>
    <div class="col-md-9">
        <div class="table-container"> {{-- Menggunakan kelas kustom untuk styling tabel keseluruhan --}}
            <div class="table-header"> {{-- Header kustom untuk judul dan tombol tambah --}}
                <h2>Manajemen Data Bezetting Kontrak</h2>
                {{-- Tombol "Tambah Data Kontrak" yang memicu modal --}}
                <a href="#" class="btn-add-unit" data-bs-toggle="modal" data-bs-target="#addDataKontrakModal">
                    <i class="fas fa-plus me-2"></i>Tambah Data Kontrak
                </a>
            </div>

            <div class="card-body">
                 {{-- Form Filter --}}
            {{-- PERUBAHAN UTAMA DI SINI: Tambahkan kelas dan struktur baru --}}
            <form action="{{ route('settings.bezetting.index') }}" method="GET" class="filter-form mb-4">
                <div class="filter-header">
                    <i class="fas fa-filter me-2"></i> Filter
                </div>
                <div class="filter-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="unit_kerja_id" class="form-label">Unit Kerja:</label>
                            <select class="form-select filter-input" id="unit_kerja_id" name="unit_kerja_id">
                                <option value="">Semua Unit Kerja</option>
                                @foreach($unitKerjaList as $unitKerja)
                                    <option value="{{ $unitKerja->id }}" {{ $selectedUnitKerjaId == $unitKerja->id ? 'selected' : '' }}>
                                        {{ $unitKerja->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="month" class="form-label">Bulan:</label>
                            <select class="form-select filter-input" id="month" name="month">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $selectedMonth == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label">Tahun:</label>
                            <select class="form-select filter-input" id="year" name="year">
                                @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-center"> {{-- Ubah align-items-end menjadi align-items-center --}}
                            <button type="submit" class="btn btn-primary w-100 filter-button">Filter</button>
                        </div>
                    </div>
                </div>
            </form>

                @if ($dataKontrak->isEmpty())
                    <p class="text-center" style="color: #6c757d;">Belum ada data bezetting kontrak untuk periode ini.</p>
                @else
                    <div class="table-responsive">
                        <table class="table-unit-kerja"> {{-- Menggunakan kelas kustom untuk tabel --}}
                            <thead>
                                <tr>
                                    <th>Unit Kerja</th>
                                    <th>Pendidikan</th>
                                    <th>Kategori Eselon</th>
                                    <th>Jumlah Pegawai</th>
                                    <th>Bulan/Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKontrak as $data)
                                <tr>
                                    <td>{{ $data->unitKerja->nama_unit ?? '-' }}</td>
                                    <td>{{ $data->pendidikan->nama_pendidikan ?? '-' }}</td>
                                    <td>{{ $data->eselon_category }}</td>
                                    <td>{{ $data->jumlah_pegawai }}</td>
                                    <td>{{ \Carbon\Carbon::createFromDate($data->tahun, $data->bulan, 1)->translatedFormat('F Y') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            {{-- Tombol "Edit" yang memicu modal --}}
                                            <a href="#" class="btn-action btn-edit edit-data-kontrak" title="Edit"
                                               data-bs-toggle="modal" data-bs-target="#editDataKontrakModal"
                                               data-id="{{ $data->id }}"
                                               data-unit-kerja-id="{{ $data->unit_kerja_id }}"
                                               data-pendidikan-id="{{ $data->pendidikan_id }}"
                                               data-eselon-category="{{ $data->eselon_category }}"
                                               data-jumlah-pegawai="{{ $data->jumlah_pegawai }}"
                                               data-bulan="{{ $data->bulan }}"
                                               data-tahun="{{ $data->tahun }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('settings.bezetting_kontrak.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
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

{{-- MODAL TAMBAH DATA KONTRAK --}}
<div class="modal fade" id="addDataKontrakModal" tabindex="-1" aria-labelledby="addDataKontrakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataKontrakModalLabel">Tambah Data Bezetting Kontrak Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('settings.bezetting_kontrak.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_unit_kerja_id" class="form-label">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" id="add_unit_kerja_id" name="unit_kerja_id" required>
                            <option value="">Pilih Unit Kerja</option>
                            @foreach($unitKerjaList as $unitKerja)
                                <option value="{{ $unitKerja->id }}">{{ $unitKerja->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add_pendidikan_id" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                        <select class="form-select" id="add_pendidikan_id" name="pendidikan_id" required>
                            <option value="">Pilih Pendidikan</option>
                            {{-- You will need to pass $pendidikanList from your controller to the view --}}
                            @foreach($pendidikanList as $pendidikan)
                                <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_eselon_category" class="form-label">Kategori Eselon <span class="text-danger">*</span></label>
                        {{-- CHANGE: Use $eselonList and $eselon->nama_eselon --}}
                        <select class="form-select" id="edit_eselon_category" name="eselon_category" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($eselonList as $eselon)
                                <option value="{{ $eselon->nama_eselon }}">
                                    {{ $eselon->nama_eselon }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add_jumlah_pegawai" class="form-label">Jumlah Pegawai <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="add_jumlah_pegawai" name="jumlah_pegawai" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="add_bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                        <select class="form-select" id="add_bulan" name="bulan" required>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}">{{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add_tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select class="form-select" id="add_tahun" name="tahun" required>
                            @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT DATA KONTRAK --}}
<div class="modal fade" id="editDataKontrakModal" tabindex="-1" aria-labelledby="editDataKontrakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataKontrakModalLabel">Edit Data Bezetting Kontrak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDataKontrakForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_unit_kerja_id" class="form-label">Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_unit_kerja_id" name="unit_kerja_id" required>
                            <option value="">Pilih Unit Kerja</option>
                            @foreach($unitKerjaList as $unitKerja)
                                <option value="{{ $unitKerja->id }}">{{ $unitKerja->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_pendidikan_id" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_pendidikan_id" name="pendidikan_id" required>
                            <option value="">Pilih Pendidikan</option>
                            {{-- You will need to pass $pendidikanList from your controller to the view --}}
                            @foreach($pendidikanList as $pendidikan)
                                <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_eselon_category" class="form-label">Kategori Eselon <span class="text-danger">*</span></label>
                        {{-- CHANGE: Use $eselonList and $eselon->nama_eselon --}}
                        <select class="form-select" id="edit_eselon_category" name="eselon_category" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($eselonList as $eselon)
                                <option value="{{ $eselon->nama_eselon }}">
                                    {{ $eselon->nama_eselon }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah_pegawai" class="form-label">Jumlah Pegawai <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_jumlah_pegawai" name="jumlah_pegawai" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="edit_bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_bulan" name="bulan" required>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}">{{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_tahun" name="tahun" required>
                            @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editDataKontrakModal = document.getElementById('editDataKontrakModal');
        editDataKontrakModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal

            // Extract info from data-bs-* attributes
            var id = button.getAttribute('data-id');
            var unitKerjaId = button.getAttribute('data-unit-kerja-id');
            var pendidikanId = button.getAttribute('data-pendidikan-id');
            var eselonCategory = button.getAttribute('data-eselon-category');
            var jumlahPegawai = button.getAttribute('data-jumlah-pegawai');
            var bulan = button.getAttribute('data-bulan');
            var tahun = button.getAttribute('data-tahun');

            // Update the modal's content.
            var modalTitle = editDataKontrakModal.querySelector('.modal-title');
            var form = editDataKontrakModal.querySelector('#editDataKontrakForm');
            var inputUnitKerja = editDataKontrakModal.querySelector('#edit_unit_kerja_id');
            var inputPendidikan = editDataKontrakModal.querySelector('#edit_pendidikan_id');
            var inputEselonCategory = editDataKontrakModal.querySelector('#edit_eselon_category');
            var inputJumlahPegawai = editDataKontrakModal.querySelector('#edit_jumlah_pegawai');
            var inputBulan = editDataKontrakModal.querySelector('#edit_bulan');
            var inputTahun = editDataKontrakModal.querySelector('#edit_tahun');

            modalTitle.textContent = 'Edit Data Bezetting Kontrak';
            form.action = '{{ route('settings.bezetting_kontrak.update', '') }}/' + id; // Set action URL dynamically
            inputUnitKerja.value = unitKerjaId;
            inputPendidikan.value = pendidikanId;
            inputEselonCategory.value = eselonCategory;
            inputJumlahPegawai.value = jumlahPegawai;
            inputBulan.value = bulan;
            inputTahun.value = tahun;
        });
    });
</script>
@endsection