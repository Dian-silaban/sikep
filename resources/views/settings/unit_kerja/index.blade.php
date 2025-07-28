@extends('layouts.app')
 {{-- Menggunakan layout utama Anda --}}

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar') {{-- Sidebar pengaturan --}}
    </div>
    <div class="col-md-9">
        {{-- Ganti div.card Bootstrap default dengan div.table-container kustom --}}
        <div class="table-container"> {{-- Menggunakan kelas kustom untuk styling tabel keseluruhan --}}
            <div class="table-header"> {{-- Header kustom untuk judul dan tombol tambah --}}
                <h2>Manajemen Unit Kerja</h2>
                {{-- Tombol "Tambah Unit Kerja" yang memicu modal --}}
                <a href="#" class="btn-add-unit" data-bs-toggle="modal" data-bs-target="#addUnitKerjaModal">
                    <i class="fas fa-plus me-2"></i>Tambah Unit Kerja
                </a>
            </div>

            @if ($unitKerjas->isEmpty())
                <p class="text-center" style="color: #6c757d;">Belum ada unit kerja yang ditambahkan.</p> {{-- Tambahkan style inline untuk warna teks --}}
            @else
                <div class="table-responsive">
                    {{-- Ganti kelas tabel Bootstrap default dengan kelas kustom --}}
                    <table class="table-unit-kerja">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Unit</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unitKerjas as $index => $unitKerja)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $unitKerja->nama_unit }}</td>
                                <td>{{ $unitKerja->deskripsi ?? '-' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        {{-- Tombol "Edit" yang memicu modal, dengan data unit kerja sebagai atribut --}}
                                        <a href="#" class="btn-action btn-edit edit-unit-kerja" title="Edit"
                                           data-bs-toggle="modal" data-bs-target="#editUnitKerjaModal"
                                           data-id="{{ $unitKerja->id }}"
                                           data-nama="{{ $unitKerja->nama_unit }}"
                                           data-deskripsi="{{ $unitKerja->deskripsi ?? '' }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        {{-- Form Hapus tetap seperti biasa --}}
                                        <form action="{{ route('settings.unit-kerja.destroy', $unitKerja->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit kerja ini? Pastikan tidak ada pegawai yang terhubung dengan unit ini.');">
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

{{-- MODAL TAMBAH UNIT KERJA --}}
<div class="modal fade" id="addUnitKerjaModal" tabindex="-1" aria-labelledby="addUnitKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUnitKerjaModalLabel">Tambah Unit Kerja Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('settings.unit-kerja.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_unit" class="form-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_unit" name="nama_unit" value="{{ old('nama_unit') }}" required>
                        {{-- Error handling untuk validasi akan muncul di halaman jika form disubmit tanpa AJAX --}}
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
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

{{-- MODAL EDIT UNIT KERJA --}}
<div class="modal fade" id="editUnitKerjaModal" tabindex="-1" aria-labelledby="editUnitKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUnitKerjaModalLabel">Edit Unit Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- Form akan diisi oleh JavaScript --}}
            <form id="editUnitKerjaForm" method="POST">
                @csrf
                @method('PUT') {{-- Penting untuk method PUT --}}
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_unit" class="form-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_unit" name="nama_unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
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
        var editUnitKerjaModal = document.getElementById('editUnitKerjaModal');
        editUnitKerjaModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget;

            // Extract info from data-bs-* attributes
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var deskripsi = button.getAttribute('data-deskripsi');

            // Update the modal's content.
            var modalTitle = editUnitKerjaModal.querySelector('.modal-title');
            var form = editUnitKerjaModal.querySelector('#editUnitKerjaForm');
            var inputNama = editUnitKerjaModal.querySelector('#edit_nama_unit');
            var inputDeskripsi = editUnitKerjaModal.querySelector('#edit_deskripsi');

            modalTitle.textContent = 'Edit Unit Kerja: ' + nama;
            form.action = '{{ route('settings.unit-kerja.update', '') }}/' + id; // Set action URL dynamically
            inputNama.value = nama;
            inputDeskripsi.value = deskripsi;
        });
    });
</script>
@endsection
