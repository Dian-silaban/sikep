<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\Eselon;
use App\Models\Pendidikan;
use App\Models\UnitKerja;
use App\Models\RiwayatGolongan;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPendidikan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RiwayatPegawaiController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen riwayat untuk pegawai tertentu.
     */
    public function index(Pegawai $pegawai, Request $request)
    {
        // Ambil semua riwayat untuk pegawai ini
        $riwayatGolongans = $pegawai->riwayatGolongan()->with('golongan')->orderBy('tmt_golongan', 'desc')->get();
        $riwayatJabatans = $pegawai->riwayatJabatan()->with(['eselon', 'unitKerja'])->orderBy('tmt_jabatan', 'desc')->get();
        $riwayatPendidikans = $pegawai->riwayatPendidikan()->with('pendidikan')->orderBy('tahun_lulus', 'desc')->get();

        // Ambil data yang dibutuhkan untuk modal-modal
        $golongans = Golongan::orderBy('urutan', 'asc')->get();
        $eselons = Eselon::orderBy('urutan', 'asc')->get();
        $unitKerjaList = UnitKerja::orderBy('nama_unit')->get();
        $pendidikans = Pendidikan::orderBy('urutan', 'asc')->get();

        // Tentukan tab yang aktif berdasarkan parameter 'tab' di URL atau dari old input (jika ada error validasi)
        $activeTab = $request->query('tab', 'golongan'); // Default ke tab 'golongan'
        if ($request->old('tab')) { // Jika ada error validasi, gunakan tab dari old input
            $activeTab = $request->old('tab');
        }

        return view('pegawai.riwayat.index', compact(
            'pegawai',
            'riwayatGolongans',
            'riwayatJabatans',
            'riwayatPendidikans',
            'golongans',
            'eselons',
            'unitKerjaList',
            'pendidikans',
            'activeTab' // Lewatkan variabel activeTab ke view
        ));
    }

    // --- Metode untuk Riwayat Golongan ---

    /**
     * Menyimpan riwayat golongan baru dan memperbarui status pegawai.
     */
    public function storeGolongan(Request $request, $pegawaiId)
    {
        try {
            // Validasi input
            $request->validate([
                'golongan_id' => 'required|exists:golongans,id',
                'tmt_golongan' => 'required|date',
                'nomor_sk' => 'nullable|string|max:255',
                'tanggal_sk' => 'nullable|date',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $pegawai = Pegawai::findOrFail($pegawaiId);
            $riwayatGolongan = $pegawai->riwayatGolongan()->create([
                'golongan_id' => $request->golongan_id,
                'tmt_golongan' => $request->tmt_golongan,
                'nomor_sk' => $request->nomor_sk,
                'tanggal_sk' => $request->tanggal_sk,
                'keterangan' => $request->keterangan,
            ]);

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentGolongan($pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawai->id, 'tab' => 'golongan']) // Redirect ke tab golongan
                ->with('success', 'Riwayat Golongan berhasil ditambahkan.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('pegawai.index')
                ->with('error', 'Pegawai tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput(['tab' => 'golongan']); // Pertahankan tab golongan jika validasi gagal
        } catch (\Exception $e) {
            Log::error('Error in storeGolongan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'golongan']) // Redirect ke tab golongan
                ->with('error', 'Terjadi kesalahan saat menambahkan riwayat golongan.');
        }
    }

    /**
     * Memperbarui riwayat golongan dan status pegawai.
     */
    public function updateGolongan(Request $request, $pegawaiId, $riwayatGolonganId)
    {
        try {
            $request->validate([
                'golongan_id' => 'required|exists:golongans,id',
                'tmt_golongan' => 'required|date',
                'nomor_sk' => 'nullable|string|max:255',
                'tanggal_sk' => 'nullable|date',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $riwayatGolongan = RiwayatGolongan::where('id', $riwayatGolonganId)
                ->where('pegawai_id', $pegawaiId)
                ->firstOrFail();

            $riwayatGolongan->update([
                'golongan_id' => $request->golongan_id,
                'tmt_golongan' => $request->tmt_golongan,
                'nomor_sk' => $request->nomor_sk,
                'tanggal_sk' => $request->tanggal_sk,
                'keterangan' => $request->keterangan,
            ]);

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentGolongan($riwayatGolongan->pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $riwayatGolongan->pegawai_id, 'tab' => 'golongan']) // Redirect ke tab golongan
                ->with('success', 'Riwayat Golongan berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'golongan'])
                ->with('error', 'Riwayat Golongan tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput(['tab' => 'golongan']); // Pertahankan tab golongan jika validasi gagal
        } catch (\Exception $e) {
            Log::error('Error in updateGolongan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'golongan'])
                ->with('error', 'Terjadi kesalahan saat memperbarui riwayat golongan.');
        }
    }

    /**
     * Menghapus riwayat golongan.
     */
    public function destroyGolongan($pegawaiId, $riwayatGolonganId)
    {
        try {
            $riwayatGolongan = RiwayatGolongan::where('id', $riwayatGolonganId)
                ->where('pegawai_id', $pegawaiId)
                ->firstOrFail();

            $pegawai = $riwayatGolongan->pegawai;
            $riwayatGolongan->delete();

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentGolongan($pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawai->id, 'tab' => 'golongan']) // Redirect ke tab golongan
                ->with('success', 'Riwayat Golongan berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'golongan'])
                ->with('error', 'Riwayat Golongan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error in destroyGolongan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'golongan'])
                ->with('error', 'Terjadi kesalahan saat menghapus riwayat golongan.');
        }
    }

    /**
     * Helper: Memperbarui golongan_id di tabel pegawai dengan riwayat terbaru.
     * Method ini sekarang bertanggung jawab penuh untuk mencari riwayat terbaru.
     */
    private function updatePegawaiCurrentGolongan(Pegawai $pegawai)
    {
        // Ambil riwayat golongan terbaru berdasarkan TMT
        $latestRiwayat = $pegawai->riwayatGolongan()
            ->orderBy('tmt_golongan', 'desc')
            ->first();

        // Update golongan_id di tabel pegawai
        if ($latestRiwayat) {
            $pegawai->golongan_id = $latestRiwayat->golongan_id;
            // Jika Anda juga menyimpan TMT Golongan di tabel pegawai, perbarui juga
            // $pegawai->tmt_golongan = $latestRiwayat->tmt_golongan;
            $pegawai->save();
        } else {
            // Jika tidak ada riwayat, set null
            $pegawai->golongan_id = null;
            // $pegawai->tmt_golongan = null;
            $pegawai->save();
        }
    }

    // --- Metode untuk Riwayat Jabatan ---

    /**
     * Menyimpan riwayat jabatan baru dan memperbarui status pegawai.
     */
    public function storeJabatan(Request $request, $pegawaiId)
    {
        try {
            \Log::info('storeJabatan called with data:', $request->all());

            $validatedData = $request->validate([
                'nama_jabatan' => 'required|string|max:255',
                'eselon_id' => 'required|exists:eselons,id',
                'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
                'tmt_jabatan' => 'required|date',
                'nomor_sk' => 'nullable|string|max:255',
                'tanggal_sk' => 'nullable|date',
                'keterangan' => 'nullable|string|max:500',
            ], [
                'nama_jabatan.required' => 'Nama jabatan harus diisi.',
                'eselon_id.required' => 'Eselon harus dipilih.',
                'eselon_id.exists' => 'Eselon yang dipilih tidak valid.',
                'unit_kerja_id.exists' => 'Unit kerja yang dipilih tidak valid.',
                'tmt_jabatan.required' => 'TMT Jabatan harus diisi.',
                'tmt_jabatan.date' => 'Format TMT Jabatan tidak valid.',
            ]);

            $pegawai = Pegawai::findOrFail($pegawaiId);
            \Log::info('Pegawai found:', ['id' => $pegawai->id, 'nama' => $pegawai->nama_lengkap]);

            $riwayatJabatan = $pegawai->riwayatJabatan()->create($validatedData);
            \Log::info('RiwayatJabatan created:', ['id' => $riwayatJabatan->id]);

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentJabatan($pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawai->id, 'tab' => 'jabatan']) // Redirect ke tab jabatan
                ->with('success', 'Riwayat Jabatan berhasil ditambahkan.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Pegawai not found:', ['pegawai_id' => $pegawaiId]);
            return redirect()
                ->route('pegawai.index')
                ->with('error', 'Pegawai tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', $e->errors());
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput(['tab' => 'jabatan']); // Pertahankan tab jabatan jika validasi gagal
        } catch (\Exception $e) {
            \Log::error('Error in storeJabatan:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'jabatan']) // Redirect ke tab jabatan
                ->with('error', 'Terjadi kesalahan saat menambahkan riwayat jabatan: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui riwayat jabatan dan status pegawai.
     */
    public function updateJabatan(Request $request, $pegawaiId, $riwayatJabatanId)
    {
        try {
            $request->validate([
                'nama_jabatan' => 'required|string|max:255',
                'eselon_id' => 'required|exists:eselons,id',
                'unit_kerja_id' => 'nullable|exists:unit_kerja,id',
                'tmt_jabatan' => 'required|date',
                'nomor_sk' => 'nullable|string|max:255',
                'tanggal_sk' => 'nullable|date',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $riwayatJabatan = RiwayatJabatan::where('id', $riwayatJabatanId)
                ->where('pegawai_id', $pegawaiId)
                ->firstOrFail();

            $riwayatJabatan->update([
                'nama_jabatan' => $request->nama_jabatan,
                'eselon_id' => $request->eselon_id,
                'unit_kerja_id' => $request->unit_kerja_id,
                'tmt_jabatan' => $request->tmt_jabatan,
                'nomor_sk' => $request->nomor_sk,
                'tanggal_sk' => $request->tanggal_sk,
                'keterangan' => $request->keterangan,
            ]);

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentJabatan($riwayatJabatan->pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $riwayatJabatan->pegawai_id, 'tab' => 'jabatan']) // Redirect ke tab jabatan
                ->with('success', 'Riwayat Jabatan berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'jabatan'])
                ->with('error', 'Riwayat Jabatan tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput(['tab' => 'jabatan']); // Pertahankan tab jabatan jika validasi gagal
        } catch (\Exception $e) {
            Log::error('Error in updateJabatan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'jabatan'])
                ->with('error', 'Terjadi kesalahan saat memperbarui riwayat jabatan.');
        }
    }

    /**
     * Menghapus riwayat jabatan.
     */
    public function destroyJabatan($pegawaiId, $riwayatJabatanId)
    {
        try {
            $riwayatJabatan = RiwayatJabatan::where('id', $riwayatJabatanId)
                ->where('pegawai_id', $pegawaiId)
                ->firstOrFail();

            $pegawai = $riwayatJabatan->pegawai;
            $riwayatJabatan->delete();

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentJabatan($pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawai->id, 'tab' => 'jabatan']) // Redirect ke tab jabatan
                ->with('success', 'Riwayat Jabatan berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'jabatan'])
                ->with('error', 'Riwayat Jabatan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error in destroyJabatan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'jabatan'])
                ->with('error', 'Terjadi kesalahan saat menghapus riwayat jabatan.');
        }
    }

    /**
     * Helper: Memperbarui jabatan dan eselon_id di tabel pegawai dengan riwayat terbaru.
     * Method ini sekarang bertanggung jawab penuh untuk mencari riwayat terbaru.
     */
    private function updatePegawaiCurrentJabatan(Pegawai $pegawai)
    {
        $latestRiwayat = $pegawai->riwayatJabatan()->orderBy('tmt_jabatan', 'desc')->first();

        if ($latestRiwayat) {
            $pegawai->jabatan = $latestRiwayat->nama_jabatan;
            $pegawai->eselon_id = $latestRiwayat->eselon_id;
            // $pegawai->unit_kerja_id = $latestRiwayat->unit_kerja_id; // Hanya jika unit_kerja_id di pegawai selalu yang terbaru dari riwayat
            $pegawai->save();
        } else {
            $pegawai->jabatan = null;
            $pegawai->eselon_id = null;
            // $pegawai->unit_kerja_id = null;
            $pegawai->save();
        }
    }


    // --- Metode untuk Riwayat Pendidikan ---

    /**
     * Menyimpan riwayat pendidikan baru dan memperbarui status pegawai.
     */
    public function storePendidikan(Request $request, $pegawaiId)
    {
        try {
            $request->validate([
                'pendidikan_id' => 'required|exists:pendidikans,id',
                'nama_institusi' => 'required|string|max:255',
                'jurusan' => 'nullable|string|max:255',
                'tahun_lulus' => 'required|integer|min:1900|max:' . (date('Y') + 5),
                'nomor_ijazah' => 'nullable|string|max:255',
                'tgl_ijazah' => 'nullable|date',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $pegawai = Pegawai::findOrFail($pegawaiId);
            $riwayatPendidikan = $pegawai->riwayatPendidikan()->create([
                'pendidikan_id' => $request->pendidikan_id,
                'nama_institusi' => $request->nama_institusi,
                'jurusan' => $request->jurusan,
                'tahun_lulus' => $request->tahun_lulus,
                'nomor_ijazah' => $request->nomor_ijazah,
                'tgl_ijazah' => $request->tgl_ijazah,
                'keterangan' => $request->keterangan,
            ]);

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentPendidikan($pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawai->id, 'tab' => 'pendidikan']) // Redirect ke tab pendidikan
                ->with('success', 'Riwayat Pendidikan berhasil ditambahkan.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('pegawai.index')
                ->with('error', 'Pegawai tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput(['tab' => 'pendidikan']); // Pertahankan tab pendidikan jika validasi gagal
        } catch (\Exception $e) {
            Log::error('Error in storePendidikan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'pendidikan']) // Redirect ke tab pendidikan
                ->with('error', 'Terjadi kesalahan saat menambahkan riwayat pendidikan.');
        }
    }

    /**
     * Memperbarui riwayat pendidikan dan status pegawai.
     */
    public function updatePendidikan(Request $request, $pegawaiId, $riwayatPendidikanId)
    {
        try {
            $request->validate([
                'pendidikan_id' => 'required|exists:pendidikans,id',
                'nama_institusi' => 'required|string|max:255',
                'jurusan' => 'nullable|string|max:255',
                'tahun_lulus' => 'required|integer|min:1900|max:' . (date('Y') + 5),
                'nomor_ijazah' => 'nullable|string|max:255',
                'tgl_ijazah' => 'nullable|date',
                'keterangan' => 'nullable|string|max:500',
            ]);

            $riwayatPendidikan = RiwayatPendidikan::where('id', $riwayatPendidikanId)
                ->where('pegawai_id', $pegawaiId)
                ->firstOrFail();

            $riwayatPendidikan->update([
                'pendidikan_id' => $request->pendidikan_id,
                'nama_institusi' => $request->nama_institusi,
                'jurusan' => $request->jurusan,
                'tahun_lulus' => $request->tahun_lulus,
                'nomor_ijazah' => $request->nomor_ijazah,
                'tgl_ijazah' => $request->tgl_ijazah,
                'keterangan' => $request->keterangan,
            ]);

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentPendidikan($riwayatPendidikan->pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $riwayatPendidikan->pegawai_id, 'tab' => 'pendidikan']) // Redirect ke tab pendidikan
                ->with('success', 'Riwayat Pendidikan berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'pendidikan'])
                ->with('error', 'Riwayat Pendidikan tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput(['tab' => 'pendidikan']); // Pertahankan tab pendidikan jika validasi gagal
        } catch (\Exception $e) {
            Log::error('Error in updatePendidikan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'pendidikan'])
                ->with('error', 'Terjadi kesalahan saat memperbarui riwayat pendidikan.');
        }
    }

    /**
     * Menghapus riwayat pendidikan.
     */
    public function destroyPendidikan($pegawaiId, $riwayatPendidikanId)
    {
        try {
            $riwayatPendidikan = RiwayatPendidikan::where('id', $riwayatPendidikanId)
                ->where('pegawai_id', $pegawaiId)
                ->firstOrFail();

            $pegawai = $riwayatPendidikan->pegawai;
            $riwayatPendidikan->delete();

            // Panggil helper tanpa argumen riwayat kedua
            $this->updatePegawaiCurrentPendidikan($pegawai);

            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawai->id, 'tab' => 'pendidikan']) // Redirect ke tab pendidikan
                ->with('success', 'Riwayat Pendidikan berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'pendidikan'])
                ->with('error', 'Riwayat Pendidikan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error in destroyPendidikan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('pegawai.riwayat.index', ['pegawai' => $pegawaiId, 'tab' => 'pendidikan'])
                ->with('error', 'Terjadi kesalahan saat menghapus riwayat pendidikan.');
        }
    }

    /**
     * Helper: Memperbarui pendidikan_id di tabel pegawai dengan riwayat terbaru.
     * Method ini sekarang bertanggung jawab penuh untuk mencari riwayat terbaru.
     */
    private function updatePegawaiCurrentPendidikan(Pegawai $pegawai)
    {
        $latestRiwayat = $pegawai->riwayatPendidikan()->orderBy('tahun_lulus', 'desc')->first();

        if ($latestRiwayat) {
            $pegawai->pendidikan_id = $latestRiwayat->pendidikan_id;
            $pegawai->save();
        } else {
            $pegawai->pendidikan_id = null;
            $pegawai->save();
        }
    }
}
