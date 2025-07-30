{{-- Modal Tambah Riwayat Jabatan --}}
<div class="modal fade" id="addJabatanModal" tabindex="-1" aria-labelledby="addJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJabatanModalLabel">Tambah Riwayat Jabatan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pegawai.riwayat.jabatan.store', $pegawai->id) }}" method="POST">
                <input type="hidden" name="tab" value="jabatan">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="eselon_id" class="form-label">Eselon <span class="text-danger">*</span></label>
                        <select class="form-select" id="eselon_id" name="eselon_id" required>
                            <option value="">Pilih Eselon</option>
                            @foreach ($eselons as $eselon)
                            <option value="{{ $eselon->id }}" {{ old('eselon_id') == $eselon->id ? 'selected' : '' }}>{{ $eselon->nama_eselon }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="unit_kerja_id" class="form-label">Unit Kerja</label>
                        <select class="form-select" id="unit_kerja_id" name="unit_kerja_id">
                            <option value="">Pilih Unit Kerja</option>
                            @foreach ($unitKerjaList as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_kerja_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tmt_jabatan" class="form-label">TMT Jabatan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tmt_jabatan" name="tmt_jabatan" value="{{ old('tmt_jabatan') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_sk_jabatan" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" id="nomor_sk_jabatan" name="nomor_sk" value="{{ old('nomor_sk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_sk_jabatan" class="form-label">Tanggal SK</label>
                        <input type="date" class="form-control" id="tanggal_sk_jabatan" name="tanggal_sk" value="{{ old('tanggal_sk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan_jabatan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan_jabatan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
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

{{-- Modal Edit Riwayat Jabatan --}}
<div class="modal fade" id="editJabatanModal" tabindex="-1" aria-labelledby="editJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJabatanModalLabel">Edit Riwayat Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editJabatanForm" method="POST">
                <input type="hidden" name="tab" value="jabatan">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_jabatan" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_jabatan" name="nama_jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_eselon_id" class="form-label">Eselon <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_eselon_id" name="eselon_id" required>
                            <option value="">Pilih Eselon</option>
                            @foreach ($eselons as $eselon)
                            <option value="{{ $eselon->id }}">{{ $eselon->nama_eselon }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_unit_kerja_id" class="form-label">Unit Kerja</label>
                        <select class="form-select" id="edit_unit_kerja_id" name="unit_kerja_id">
                            <option value="">Pilih Unit Kerja</option>
                            @foreach ($unitKerjaList as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tmt_jabatan" class="form-label">TMT Jabatan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_tmt_jabatan" name="tmt_jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor_sk_jabatan" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" id="edit_nomor_sk_jabatan" name="nomor_sk">
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_sk_jabatan" class="form-label">Tanggal SK</label>
                        <input type="date" class="form-control" id="edit_tanggal_sk_jabatan" name="tanggal_sk">
                    </div>
                    <div class="mb-3">
                        <label for="edit_keterangan_jabatan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan_jabatan" name="keterangan" rows="3"></textarea>
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

{{-- JavaScript untuk handle edit modal jabatan --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle edit modal jabatan
        const editJabatanButtons = document.querySelectorAll('button[data-bs-target="#editJabatanModal"]');

        editJabatanButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const namaJabatan = this.getAttribute('data-nama_jabatan');
                const eselonId = this.getAttribute('data-eselon_id');
                const unitKerjaId = this.getAttribute('data-unit_kerja_id');
                const tmtJabatan = this.getAttribute('data-tmt_jabatan');
                const nomorSk = this.getAttribute('data-nomor_sk');
                const tanggalSk = this.getAttribute('data-tanggal_sk');
                const keterangan = this.getAttribute('data-keterangan');

                // Set form action
                const form = document.getElementById('editJabatanForm');
                form.action = `{{ route('pegawai.riwayat.jabatan.update', [$pegawai->id, '__ID__']) }}`.replace('__ID__', id);

                // Fill form fields
                document.getElementById('edit_nama_jabatan').value = namaJabatan || '';
                document.getElementById('edit_eselon_id').value = eselonId || '';
                document.getElementById('edit_unit_kerja_id').value = unitKerjaId || '';
                document.getElementById('edit_tmt_jabatan').value = tmtJabatan || '';
                document.getElementById('edit_nomor_sk_jabatan').value = nomorSk || '';
                document.getElementById('edit_tanggal_sk_jabatan').value = tanggalSk || '';
                document.getElementById('edit_keterangan_jabatan').value = keterangan || '';
            });
        });
    });
</script>