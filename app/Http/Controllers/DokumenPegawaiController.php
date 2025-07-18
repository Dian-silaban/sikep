<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\JenisDokumen;
use App\Models\DokumenPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenPegawaiController extends Controller
{
    /**
     * Display a listing of documents for a specific pegawai.
     */
    public function index(Pegawai $pegawai)
    {
        $dokumen = $pegawai->dokumen()->orderBy('tanggal_upload', 'desc')->get();
        return view('dokumen.index', compact('pegawai', 'dokumen'));
    }

    /**
     * Show the form for creating a new document for a specific pegawai.
     */
    public function create(Pegawai $pegawai)
    {
        $jenis_dokumen = JenisDokumen::all();
        return view('dokumen.create', compact('pegawai', 'jenis_dokumen'));
    }

    /**
     * Store a newly created document in storage, handling versioning.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30720',  
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jenisDokumen = JenisDokumen::find($request->jenis_dokumen_id);

        // LOGIKA VERSIONING DOKUMEN:
        $latestVersionDocForType = DokumenPegawai::where('pegawai_id', $pegawai->id)
                                                ->where('jenis_dokumen_id', $jenisDokumen->id)
                                                ->orderBy('versi_dokumen', 'desc')
                                                ->first();

        $newVersion = 1;
        if ($latestVersionDocForType) {
            $newVersion = $latestVersionDocForType->versi_dokumen + 1;
        }

        $currentActiveDoc = DokumenPegawai::where('pegawai_id', $pegawai->id)
                                        ->where('jenis_dokumen_id', $jenisDokumen->id)
                                        ->where('status_dokumen', 'Aktif')
                                        ->first();
        if ($currentActiveDoc) {
            $currentActiveDoc->status_dokumen = 'Revisi';
            $currentActiveDoc->save();
        }

        // Proses upload file
        $file = $request->file('file_dokumen');
        $namaFileAsli = $file->getClientOriginalName();
        $ekstensi = $file->getClientOriginalExtension();
        $namaFileTersimpan = $pegawai->nip . '_' . Str::slug($jenisDokumen->nama_jenis) . '_V' . $newVersion . '_' . Str::uuid() . '.' . $ekstensi;

        $path = $file->storeAs('public/dokumen_pegawai/' . $pegawai->nip, $namaFileTersimpan);
        $publicPath = Storage::url($path);

        DokumenPegawai::create([
            'pegawai_id' => $pegawai->id,
            'jenis_dokumen_id' => $jenisDokumen->id,
            'nama_file_asli' => $namaFileAsli,
            'nama_file_tersimpan' => $namaFileTersimpan,
            'path_file' => $publicPath,
            'tanggal_upload' => now(),
            'versi_dokumen' => $newVersion,
            'status_dokumen' => 'Aktif',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pegawai.show', $pegawai->id)->with('success', 'Dokumen berhasil diunggah dan versi dikelola.');
    }

    /**
     * Download the specified document.
     */
    public function download(DokumenPegawai $dokumen_pegawai)
    {
        $filePath = str_replace('/storage/', 'public/', $dokumen_pegawai->path_file);

        if (Storage::exists($filePath)) {
            return Storage::download($filePath, $dokumen_pegawai->nama_file_asli);
        }

        return back()->with('error', 'File tidak ditemukan atau sudah tidak ada.');
    }

    /**
     * Permanently remove the specified document.
     * Menghapus dokumen secara fisik dari storage dan database.
     */
    public function destroyPermanent(DokumenPegawai $dokumen_pegawai)
    {
        $filePath = str_replace('/storage/', 'public/', $dokumen_pegawai->path_file);
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $dokumen_pegawai->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus permanen.');
    }

    /**
     * Show the form for editing the specified document.
     * Menampilkan form untuk mengedit metadata dokumen.
     */
    public function edit(DokumenPegawai $dokumen_pegawai)
    {
        $jenis_dokumen = JenisDokumen::all(); // Untuk dropdown jenis dokumen
        // Pastikan dokumen_pegawai ini terkait dengan pegawai yang masih ada, jika ada soft-delete pegawai
        $pegawai = $dokumen_pegawai->pegawai; // Mengambil data pegawai terkait

        return view('dokumen.edit', compact('dokumen_pegawai', 'jenis_dokumen', 'pegawai'));
    }

    /**
     * Update the specified document's metadata, or replace its file with a new version.
     * Memperbarui metadata dokumen, atau mengganti file-nya dengan versi baru.
     */
    public function update(Request $request, DokumenPegawai $dokumen_pegawai)
    {
        $request->validate([
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'nama_file_asli' => 'required|string|max:255', // Nama file baru harus diisi dari FORM
            'keterangan' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30720', // File baru opsional
        ]);

        $jenisDokumen = JenisDokumen::find($request->jenis_dokumen_id);
        $pegawai = $dokumen_pegawai->pegawai;

        // Data yang akan di-update, selalu ambil nama_file_asli dari request form
        $updateData = [
            'jenis_dokumen_id' => $request->jenis_dokumen_id,
            'nama_file_asli' => $request->nama_file_asli, // BARIS UTAMA PERUBAHAN: Selalu ambil dari input form
            'keterangan' => $request->keterangan,
        ];

        // Logika untuk file baru (jika diupload)
        if ($request->hasFile('file_dokumen')) {
            // Ini akan memicu logika versioning seperti di metode store()

            // 1. Dapatkan versi tertinggi yang ada untuk jenis dokumen ini pada pegawai ini
            $latestVersionDocForType = DokumenPegawai::where('pegawai_id', $pegawai->id)
                                                    ->where('jenis_dokumen_id', $jenisDokumen->id)
                                                    ->orderBy('versi_dokumen', 'desc')
                                                    ->first();

            $newVersion = 1;
            if ($latestVersionDocForType) {
                $newVersion = $latestVersionDocForType->versi_dokumen + 1;
            }

            // 2. Tandai dokumen yang saat ini AKTIF dengan jenis yang sama menjadi 'Revisi'.
            $currentActiveDoc = DokumenPegawai::where('pegawai_id', $pegawai->id)
                                            ->where('jenis_dokumen_id', $jenisDokumen->id)
                                            ->where('status_dokumen', 'Aktif')
                                            ->first();
            if ($currentActiveDoc) {
                $currentActiveDoc->status_dokumen = 'Revisi';
                $currentActiveDoc->save();
            }

            // Hapus file fisik dokumen_lama yang sedang di-update jika dokumen_lama tersebut yang aktif dan diganti.
            if ($dokumen_pegawai->status_dokumen == 'Aktif') {
                $oldFilePath = str_replace('/storage/', 'public/', $dokumen_pegawai->path_file);
                if (Storage::exists($oldFilePath)) {
                    Storage::delete($oldFilePath);
                }
            }

            // Proses upload file baru
            $file = $request->file('file_dokumen');
            // $namaFileAsliBaru = $file->getClientOriginalName(); // BARIS INI TIDAK DIGUNAKAN LAGI UNTUK NAMA_FILE_ASLI
            $ekstensi = $file->getClientOriginalExtension();
            $namaFileTersimpanBaru = $pegawai->nip . '_' . Str::slug($jenisDokumen->nama_jenis) . '_V' . $newVersion . '_' . Str::uuid() . '.' . $ekstensi;
            $path = $file->storeAs('public/dokumen_pegawai/' . $pegawai->nip, $namaFileTersimpanBaru);
            $publicPath = Storage::url($path);

            // Perbarui data yang akan di-update dengan info file baru
            $updateData['nama_file_tersimpan'] = $namaFileTersimpanBaru;
            $updateData['path_file'] = $publicPath;
            $updateData['tanggal_upload'] = now();
            $updateData['versi_dokumen'] = $newVersion;
            $updateData['status_dokumen'] = 'Aktif'; // Status menjadi aktif
        }

        // Lakukan update ke database
        $dokumen_pegawai->update($updateData);

        return redirect()->route('pegawai.show', $dokumen_pegawai->pegawai_id)->with('success', 'Dokumen berhasil diperbarui.');
    }

}