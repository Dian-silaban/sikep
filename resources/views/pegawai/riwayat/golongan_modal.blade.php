{{-- Modal Tambah Riwayat Golongan --}}
<div class="modal fade" id="addGolonganModal" tabindex="-1" aria-labelledby="addGolonganModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Riwayat Golongan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pegawai.riwayat.golongan.store', $pegawai->id) }}" method="POST">
                {{-- Tambahkan hidden input ini untuk menyimpan tab aktif --}}
                <input type="hidden" name="tab" value="golongan">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="golongan_id" class="form-label">Golongan <span class="text-danger">*</span></label>
                        <select class="form-select" id="golongan_id" name="golongan_id" required>
                            <option value="">Pilih Golongan</option>
                            @foreach ($golongans as $golongan)
                                <option value="{{ $golongan->id }}" {{ old('golongan_id') == $golongan->id ? 'selected' : '' }}>{{ $golongan->nama_golongan }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tmt_golongan" class="form-label">TMT Golongan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tmt_golongan" name="tmt_golongan" value="{{ old('tmt_golongan') }}" required>       
                    </div>
                    <div class="mb-3">
                        <label for="nomor_sk" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" id="nomor_sk" name="nomor_sk" value="{{ old('nomor_sk') }}">    
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_sk" class="form-label">Tanggal SK</label>
                        <input type="date" class="form-control" id="tanggal_sk" name="tanggal_sk" value="{{ old('tanggal_sk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Riwayat Golongan --}}
<div class="modal fade" id="editGolonganModal" tabindex="-1" aria-labelledby="editGolonganModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGolonganModalLabel">Edit Riwayat Golongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editGolonganForm" method="POST">
                {{-- Tambahkan hidden input ini untuk menyimpan tab aktif --}}
                <input type="hidden" name="tab" value="golongan">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_golongan_id" class="form-label">Golongan <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_golongan_id" name="golongan_id" required>
                            <option value="">Pilih Golongan</option>
                            @foreach ($golongans as $golongan)
                                <option value="{{ $golongan->id }}">{{ $golongan->nama_golongan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tmt_golongan" class="form-label">TMT Golongan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_tmt_golongan" name="tmt_golongan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor_sk" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" id="edit_nomor_sk" name="nomor_sk">
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_sk" class="form-label">Tanggal SK</label>
                        <input type="date" class="form-control" id="edit_tanggal_sk" name="tanggal_sk">
                    </div>
                    <div class="mb-3">
                        <label for="edit_keterangan_golongan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan_golongan" name="keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript untuk handle edit modal --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit modal
    const editButtons = document.querySelectorAll('button[data-bs-target="#editGolonganModal"]');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const golonganId = this.getAttribute('data-golongan_id');
            const tmtGolongan = this.getAttribute('data-tmt_golongan');
            const nomorSk = this.getAttribute('data-nomor_sk');
            const tanggalSk = this.getAttribute('data-tanggal_sk');
            const keterangan = this.getAttribute('data-keterangan');
            
            // Set form action
            const form = document.getElementById('editGolonganForm');
            form.action = `{{ route('pegawai.riwayat.golongan.update', [$pegawai->id, '__ID__']) }}`.replace('__ID__', id);
            
            // Fill form fields
            document.getElementById('edit_golongan_id').value = golonganId;
            document.getElementById('edit_tmt_golongan').value = tmtGolongan;
            document.getElementById('edit_nomor_sk').value = nomorSk;
            document.getElementById('edit_tanggal_sk').value = tanggalSk;
            document.getElementById('edit_keterangan_golongan').value = keterangan;
        });
    });
});
</script>
