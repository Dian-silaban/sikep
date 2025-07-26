<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DokumenPegawaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // Pastikan ini juga ada jika menggunakan Manajemen Pengguna
use App\Http\Controllers\DocumentMigrationController;
use App\Http\Controllers\UnitKerjaController; // Tambahkan ini
use App\Http\Controllers\JenisDokumenController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

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
// Semua rute yang memerlukan otentikasi harus berada dalam satu grup middleware 'auth' ini.
Route::middleware('auth')->group(function () {
    // Rute default setelah login, mengarahkan ke daftar pegawai
    Route::get('/', function () {
        return redirect()->route('pegawai.index');
    });

    // Rute Manajemen Pegawai
    Route::resource('pegawai', PegawaiController::class);

    // Rute untuk Ekspor Data Pegawai
    Route::get('pegawai/export/excel', [PegawaiController::class, 'exportExcel'])->name('pegawai.export.excel');

    // Rute Manajemen Dokumen
    // Perhatikan: 'dokumen.delete' di sini mengarah ke destroyPermanent, pastikan konsisten
    Route::delete('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'destroyPermanent'])->name('dokumen.delete');
    Route::get('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'index'])->name('pegawai.dokumen.index');
    Route::post('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'store'])->name('pegawai.dokumen.store');
    Route::get('dokumen/{dokumen_pegawai}/download', [DokumenPegawaiController::class, 'download'])->name('dokumen.download');
    
    // Rute untuk Edit Dokumen
    Route::get('dokumen/{dokumen_pegawai}/edit', [DokumenPegawaiController::class, 'edit'])->name('dokumen.edit');
    Route::put('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'update'])->name('dokumen.update');
    
    // Rute untuk Pengaturan
    Route::prefix('settings')->name('settings.')->group(function () {
        // Halaman utama pengaturan
        Route::get('/', function () {
            return view('settings.index');
        })->name('index');

        // Rute untuk fitur Salin Dokumen
        Route::prefix('document-migration')->name('document_migration.')->group(function () {
            Route::get('/', [DocumentMigrationController::class, 'index'])->name('index');
            Route::post('/', [DocumentMigrationController::class, 'startMigration'])->name('start');
        });

        // Rute untuk Manajemen Unit Kerja
        Route::resource('unit-kerja', UnitKerjaController::class)->except(['show']);

        // Rute untuk Manajemen Jenis Dokumen
        Route::resource('jenis-dokumen', JenisDokumenController::class)->except(['show']);
    });

    // Rute Manajemen Pengguna (jika Anda mengimplementasikannya)
    // Route::resource('users', UserController::class); // Contoh: jika Anda menggunakan UserController
});

// Hapus atau komentari `require __DIR__.'/auth.php';` jika Anda tidak menggunakan Breeze.
// require __DIR__.'/auth.php';
