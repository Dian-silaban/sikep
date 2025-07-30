{{-- Modal Tambah Riwayat Pendidikan --}}
<div class="modal fade" id="addPendidikanModal" tabindex="-1" aria-labelledby="addPendidikanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPendidikanModalLabel">Tambah Riwayat Pendidikan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pegawai.riwayat.pendidikan.store', $pegawai->id) }}" method="POST">
                <input type="hidden" name="tab" value="pendidikan">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pendidikan_id" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                        <select class="form-select" id="pendidikan_id" name="pendidikan_id" required>
                            <option value="">Pilih Pendidikan</option>
                            @foreach ($pendidikans as $pendidikan)
                                <option value="{{ $pendidikan->id }}" {{ old('pendidikan_id') == $pendidikan->id ? 'selected' : '' }}>{{ $pendidikan->nama_pendidikan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_institusi" class="form-label">Nama Institusi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_institusi" name="nama_institusi" value="{{ old('nama_institusi') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ old('jurusan') }}">
                    </div>
                    <div class="mb-3">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="tahun_lulus" name="tahun_lulus" value="{{ old('tahun_lulus') ?? date('Y') }}" required min="1900" max="{{ date('Y') + 5 }}">
                    </div>
                    <div class="mb-3">
                        <label for="nomor_ijazah" class="form-label">Nomor Ijazah</label>
                        <input type="text" class="form-control" id="nomor_ijazah" name="nomor_ijazah" value="{{ old('nomor_ijazah') }}">
                    </div>
                    <div class="mb-3">
                        <label for="tgl_ijazah" class="form-label">Tanggal Ijazah</label>
                        <input type="date" class="form-control" id="tgl_ijazah" name="tgl_ijazah" value="{{ old('tgl_ijazah') }}">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan_pendidikan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan_pendidikan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
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

{{-- Modal Edit Riwayat Pendidikan --}}
<div class="modal fade" id="editPendidikanModal" tabindex="-1" aria-labelledby="editPendidikanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPendidikanModalLabel">Edit Riwayat Pendidikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPendidikanForm" method="POST">
                <input type="hidden" name="tab" value="pendidikan">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_pendidikan_id" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_pendidikan_id" name="pendidikan_id" required>
                            <option value="">Pilih Pendidikan</option>
                            @foreach ($pendidikans as $pendidikan)
                                <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama_institusi" class="form-label">Nama Institusi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_institusi" name="nama_institusi" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="edit_jurusan" name="jurusan">
                    </div>
                    <div class="mb-3">
                        <label for="edit_tahun_lulus" class="form-label">Tahun Lulus <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_tahun_lulus" name="tahun_lulus" required min="1900" max="{{ date('Y') + 5 }}">
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor_ijazah" class="form-label">Nomor Ijazah</label>
                        <input type="text" class="form-control" id="edit_nomor_ijazah" name="nomor_ijazah">
                    </div>
                    <div class="mb-3">
                        <label for="edit_tgl_ijazah" class="form-label">Tanggal Ijazah</label>
                        <input type="date" class="form-control" id="edit_tgl_ijazah" name="tgl_ijazah">
                    </div>
                    <div class="mb-3">
                        <label for="edit_keterangan_pendidikan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan_pendidikan" name="keterangan" rows="3"></textarea>
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

{{-- JavaScript untuk handle edit modal pendidikan --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit modal pendidikan
    const editPendidikanButtons = document.querySelectorAll('button[data-bs-target="#editPendidikanModal"]');
    
    editPendidikanButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const pendidikanId = this.getAttribute('data-pendidikan_id');
            const namaInstitusi = this.getAttribute('data-nama_institusi');
            const jurusan = this.getAttribute('data-jurusan');
            const tahunLulus = this.getAttribute('data-tahun_lulus');
            const nomorIjazah = this.getAttribute('data-nomor_ijazah');
            const tglIjazah = this.getAttribute('data-tgl_ijazah');
            const keterangan = this.getAttribute('data-keterangan');
            
            // Set form action
            const form = document.getElementById('editPendidikanForm');
            form.action = `{{ route('pegawai.riwayat.pendidikan.update', [$pegawai->id, '__ID__']) }}`.replace('__ID__', id);
            
            // Fill form fields
            document.getElementById('edit_pendidikan_id').value = pendidikanId || '';
            document.getElementById('edit_nama_institusi').value = namaInstitusi || '';
            document.getElementById('edit_jurusan').value = jurusan || '';
            document.getElementById('edit_tahun_lulus').value = tahunLulus || '';
            document.getElementById('edit_nomor_ijazah').value = nomorIjazah || '';
            document.getElementById('edit_tgl_ijazah').value = tglIjazah || '';
            document.getElementById('edit_keterangan_pendidikan').value = keterangan || '';
        });
    });
});
</script>