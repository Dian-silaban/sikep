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
                <h2>Manajemen Jenis Dokumen</h2>
                {{-- Tombol "Tambah Jenis Dokumen" yang memicu modal --}}
                <a href="#" class="btn-add-unit" data-bs-toggle="modal" data-bs-target="#addJenisDokumenModal">
                    <i class="fas fa-plus me-2"></i>Tambah Jenis Dokumen
                </a>
            </div>

            @if ($jenisDokumens->isEmpty())
                <p class="text-center" style="color: #6c757d;">Belum ada jenis dokumen yang ditambahkan.</p>
            @else
                <div class="table-responsive">
                    {{-- Ganti kelas tabel Bootstrap default dengan kelas kustom --}}
                    <table class="table-unit-kerja"> {{-- Menggunakan kelas yang sama dengan tabel unit kerja --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Jenis</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenisDokumens as $index => $jenisDokumen)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $jenisDokumen->nama_jenis }}</td>
                                <td>{{ $jenisDokumen->deskripsi ?? '-' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        {{-- Tombol "Edit" yang memicu modal, dengan data jenis dokumen sebagai atribut --}}
                                        <a href="#" class="btn-action btn-edit edit-jenis-dokumen" title="Edit"
                                           data-bs-toggle="modal" data-bs-target="#editJenisDokumenModal"
                                           data-id="{{ $jenisDokumen->id }}"
                                           data-nama="{{ $jenisDokumen->nama_jenis }}"
                                           data-deskripsi="{{ $jenisDokumen->deskripsi ?? '' }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        {{-- Form Hapus tetap seperti biasa --}}
                                        <form action="{{ route('settings.jenis-dokumen.destroy', $jenisDokumen->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis dokumen ini? Pastikan tidak ada dokumen pegawai yang terhubung dengan jenis ini.');">
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

{{-- MODAL TAMBAH JENIS DOKUMEN --}}
<div class="modal fade" id="addJenisDokumenModal" tabindex="-1" aria-labelledby="addJenisDokumenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJenisDokumenModalLabel">Tambah Jenis Dokumen Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('settings.jenis-dokumen.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_jenis" class="form-label">Nama Jenis Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" value="{{ old('nama_jenis') }}" required>
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

{{-- MODAL EDIT JENIS DOKUMEN --}}
<div class="modal fade" id="editJenisDokumenModal" tabindex="-1" aria-labelledby="editJenisDokumenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJenisDokumenModalLabel">Edit Jenis Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- Form akan diisi oleh JavaScript --}}
            <form id="editJenisDokumenForm" method="POST">
                @csrf
                @method('PUT') {{-- Penting untuk method PUT --}}
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_jenis" class="form-label">Nama Jenis Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_jenis" name="nama_jenis" required>
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
        // Script untuk Modal Edit Jenis Dokumen
        var editJenisDokumenModal = document.getElementById('editJenisDokumenModal');
        editJenisDokumenModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var deskripsi = button.getAttribute('data-deskripsi');

            var modalTitle = editJenisDokumenModal.querySelector('.modal-title');
            var form = editJenisDokumenModal.querySelector('#editJenisDokumenForm');
            var inputNama = editJenisDokumenModal.querySelector('#edit_nama_jenis');
            var inputDeskripsi = editJenisDokumenModal.querySelector('#edit_deskripsi');

            modalTitle.textContent = 'Edit Jenis Dokumen: ' + nama;
            form.action = '{{ route('settings.jenis-dokumen.update', '') }}/' + id;
            inputNama.value = nama;
            inputDeskripsi.value = deskripsi;
        });
    });
</script>
@endsection
