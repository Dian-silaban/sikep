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
     * Menampilkan daftar dokumen untuk seorang pegawai.
     * (Opsional, viewnya bisa digabung di pegawai.show)
     */
    public function index(Pegawai $pegawai)
    {
        $dokumen = $pegawai->dokumen()->orderBy('tanggal_upload', 'desc')->get();
        return view('dokumen.index', compact('pegawai', 'dokumen'));
    }

    /**
     * Show the form for creating a new document for a specific pegawai.
     * Menampilkan formulir untuk mengunggah dokumen baru.
     * (Opsional, formnya bisa digabung di pegawai.show)
     */
    public function create(Pegawai $pegawai)
    {
        $jenis_dokumen = JenisDokumen::all();
        return view('dokumen.create', compact('pegawai', 'jenis_dokumen'));
    }

    /**
     * Store a newly created document in storage, handling versioning.
     * Menyimpan dokumen baru ke database dan mengelola versinya.
     */
      public function store(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // Max 10MB
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jenisDokumen = JenisDokumen::find($request->jenis_dokumen_id);

        // LOGIKA VERSIONING DOKUMEN:
        // 1. Temukan versi dokumen tertinggi yang pernah ada untuk jenis dokumen ini pada pegawai ini.
        $latestVersionDocForType = DokumenPegawai::where('pegawai_id', $pegawai->id)
                                                ->where('jenis_dokumen_id', $jenisDokumen->id)
                                                ->orderBy('versi_dokumen', 'desc') // Urutkan dari versi tertinggi
                                                ->first(); // Ambil yang paling atas (tertinggi)

        $newVersion = 1; // Default jika belum ada dokumen sama sekali
        if ($latestVersionDocForType) {
            // Jika sudah ada dokumen sebelumnya, versi baru adalah versi tertinggi + 1
            $newVersion = $latestVersionDocForType->versi_dokumen + 1;
        }

        // 2. Tandai dokumen yang saat ini AKTIF dengan jenis yang sama menjadi 'Revisi'.
        // (Ini harus dilakukan SETELAH menemukan newVersion untuk menghindari konflik jika latestVersionDocForType adalah dokumen yang baru saja kita non-aktifkan)
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

        // Buat entri baru di tabel dokumen_pegawai
        DokumenPegawai::create([
            'pegawai_id' => $pegawai->id,
            'jenis_dokumen_id' => $jenisDokumen->id,
            'nama_file_asli' => $namaFileAsli,
            'nama_file_tersimpan' => $namaFileTersimpan,
            'path_file' => $publicPath,
            'tanggal_upload' => now(),
            'versi_dokumen' => $newVersion, // Gunakan versi yang sudah dihitung
            'status_dokumen' => 'Aktif',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pegawai.show', $pegawai->id)->with('success', 'Dokumen berhasil diunggah dan versi dikelola.');
    }

    /**
     * Download the specified document.
     * Mengunduh file dokumen.
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
     * Soft delete the specified document.
     * Menghapus dokumen secara "soft" (mengubah statusnya menjadi Dihapus).
     * File fisik tetap ada di server.
     */
    public function destroy(DokumenPegawai $dokumen_pegawai)
    {
        $dokumen_pegawai->status_dokumen = 'Dihapus';
        $dokumen_pegawai->save();

        return redirect()->back()->with('success', 'Dokumen berhasil dinon-aktifkan (soft delete).');
    }
}