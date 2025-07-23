<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DokumenPegawaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // Pastikan ini juga ada jika menggunakan Manajemen Pengguna
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentMigrationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk autentikasi manual
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang perlu dilindungi oleh autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('pegawai.index');
    });

    // Rute Manajemen Pegawai
    Route::resource('pegawai', PegawaiController::class);

    Route::middleware('auth')->group(function () {
    // ... (rute-rute Pegawai, Dokumen, Users) ...

    // BARU: Rute untuk Ekspor Data Pegawai
        Route::get('pegawai/export/excel', [PegawaiController::class, 'exportExcel'])->name('pegawai.export.excel');

        // Rute Manajemen Dokumen
        Route::delete('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'destroyPermanent'])->name('dokumen.delete');
        Route::get('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'index'])->name('pegawai.dokumen.index');
        Route::post('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'store'])->name('pegawai.dokumen.store');
        Route::get('dokumen/{dokumen_pegawai}/download', [DokumenPegawaiController::class, 'download'])->name('dokumen.download');
    
        // BARU: Rute untuk Edit Dokumen
        Route::get('dokumen/{dokumen_pegawai}/edit', [DokumenPegawaiController::class, 'edit'])->name('dokumen.edit');
        Route::put('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'update'])->name('dokumen.update');
    
        Route::get('settings/document-migration', [DocumentMigrationController::class, 'index'])->name('settings.document_migration.index');
        Route::post('settings/document-migration', [DocumentMigrationController::class, 'startMigration'])->name('settings.document_migration.start');

    });

    // Rute Manajemen Pengguna (jika Anda mengimplementasikannya)
    // Route::resource('users', UserController::class); // Contoh: jika Anda menggunakan UserController

});

// Hapus atau komentari `require __DIR__.'/auth.php';` jika Anda tidak menggunakan Breeze.
// require __DIR__.'/auth.php';