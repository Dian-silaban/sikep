<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CopyAllDocumentsToBackup;
use App\Models\Setting; // Pastikan ini di-use
use Illuminate\Support\Facades\File; // Pastikan ini di-use

class DocumentMigrationController extends Controller
{
    /**
     * Menampilkan form untuk memicu penyalinan dokumen.
     */
    public function index()
    {
        // PERBAIKAN: Gunakan null coalescing operator (??) untuk memberikan nilai default jika first() mengembalikan null
        $lastBackupPath = Setting::where('key', 'last_backup_destination_path')->first()->value ?? '';
        
        return view('settings.document_migration', compact('lastBackupPath'));
    }

    /**
     * Memicu job penyalinan semua dokumen.
     */
    public function startMigration(Request $request)
    {
        $request->validate([
            'destination_path' => 'required|string|max:1000',
        ]);

        $destinationPath = $request->input('destination_path');

        // Optional: Cek izin tulis di path tujuan (ini tetap penting)
        try {
            $testPath = $destinationPath . DIRECTORY_SEPARATOR . 'dokumen_pegawai' . DIRECTORY_SEPARATOR . 'TEST_PERMISSION_FOLDER';
            if (!File::isDirectory($testPath)) {
                File::makeDirectory($testPath, 0777, true, true);
            }
            if (!File::isWritable($testPath)) {
                return back()->with('error', 'Folder tujuan tidak dapat ditulis. Pastikan aplikasi memiliki izin yang benar.');
            }
            if (File::isDirectory($testPath)) {
                File::deleteDirectory($testPath);
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Path tujuan tidak valid atau tidak dapat diakses: ' . $e->getMessage());
        }

        // Simpan path tujuan untuk referensi berikutnya di pengaturan
        Setting::updateOrCreate(
            ['key' => 'last_backup_destination_path'],
            ['value' => $destinationPath]
        );

        // Kirim Job ke queue
        CopyAllDocumentsToBackup::dispatch($destinationPath);

        return redirect()->back()->with('success', 'Proses penyalinan dokumen telah dimulai di latar belakang. Silakan cek folder tujuan setelah beberapa waktu.');
    }
}