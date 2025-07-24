<?php

namespace App\Jobs;

use App\Models\DokumenPegawai;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage; // PENTING: Untuk Storage::disk()
use Illuminate\Support\Facades\File;     // PENTING: Untuk File::exists(), File::copy(), File::makeDirectory()
use Illuminate\Support\Facades\Log;      // PENTING: Untuk Log::warning(), Log::error()
use Illuminate\Support\Str;              // PENTING: Untuk Str::replaceFirst

class CopyAllDocumentsToBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $destinationPath;

    /**
     * Create a new job instance.
     */
    public function __construct(string $destinationPath)
    {
        $this->destinationPath = $destinationPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Ambil semua dokumen yang statusnya AKTIF atau REVISI (kecuali Dihapus)
        $dokumenPegawai = DokumenPegawai::whereNotIn('status_dokumen', ['Dihapus'])->get(); 

        foreach ($dokumenPegawai as $dokumen) {
            // Pastikan relasi pegawai dimuat untuk menghindari error jika belum
            if (!$dokumen->relationLoaded('pegawai')) {
                $dokumen->load('pegawai');
            }
            // Pastikan pegawai terkait ada, untuk mencegah error jika pegawai sudah terhapus tapi dokumen masih ada
            if (!$dokumen->pegawai) {
                Log::warning("Copy Job: Dokumen ID: " . $dokumen->id . " tidak memiliki pegawai terkait. Dilewati.");
                continue;
            }


            // Dapatkan path absolut file di lokasi primer (storage/app/public)
            // Ambil path relatif dari path_file (misal: 'dokumen/abc.pdf')
            $pathRelatifDisk = $dokumen->path_file;
            // Jika path_file berisi URL, ambil bagian setelah '/storage/'
            if (Str::startsWith($pathRelatifDisk, '/storage/')) {
                $pathRelatifDisk = Str::replaceFirst('/storage/', '', $pathRelatifDisk);
            } elseif (Str::contains($pathRelatifDisk, '/storage/')) {
                $pathRelatifDisk = substr($pathRelatifDisk, strpos($pathRelatifDisk, '/storage/') + 9);
            }
            $sourceFilePath = storage_path('app/public/' . $pathRelatifDisk);

            // Pastikan file sumber ada sebelum menyalin
            if (!File::exists($sourceFilePath)) {
                Log::warning("Copy Job: File dokumen tidak ditemukan di lokasi primer: " . $sourceFilePath . " untuk dokumen ID: " . $dokumen->id);
                continue;
            }

            // Tentukan path tujuan di folder backup
            $backupSubFolder = $this->destinationPath . DIRECTORY_SEPARATOR . 'dokumen_pegawai' . DIRECTORY_SEPARATOR . $dokumen->pegawai->nip;
            $destinationFilePath = $backupSubFolder . DIRECTORY_SEPARATOR . $dokumen->nama_file_tersimpan;

            try {
                // Pastikan folder tujuan ada (buat rekursif jika belum)
                if (!File::isDirectory($backupSubFolder)) {
                    File::makeDirectory($backupSubFolder, 0777, true, true);
                }

                // Salin file
                File::copy($sourceFilePath, $destinationFilePath);
                Log::info("Copy Job: Dokumen berhasil disalin: " . $dokumen->nama_file_tersimpan . " ke " . $destinationFilePath);

            } catch (\Exception $e) {
                // Tangani error jika penyalinan gagal (misal: izin, path tidak valid)
                Log::error("Copy Job: Gagal menyalin dokumen ID " . $dokumen->id . " (" . $dokumen->nama_file_tersimpan . ") Error: " . $e->getMessage());
            }
        }
    }
}