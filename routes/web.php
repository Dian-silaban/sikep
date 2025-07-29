<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DokumenPegawaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentMigrationController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\BezettingController;
use App\Http\Controllers\BezettingKontrakController;
use App\Http\Controllers\RiwayatPegawaiController; // Tambahkan ini
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsulanBerkalaController; // Tambahkan ini
use Illuminate\Support\Facades\Auth;


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

    // Rute untuk Ekspor Data Pegawai
    Route::get('pegawai/export/excel', [PegawaiController::class, 'exportExcel'])->name('pegawai.export.excel');

    // Rute Manajemen Dokumen
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

        // Rute untuk Laporan Bezetting
        Route::prefix('bezetting')->name('bezetting.')->group(function () {
            Route::get('/', [BezettingController::class, 'index'])->name('index');
            Route::post('/export-excel', [BezettingController::class, 'exportExcel'])->name('export_excel');
        });

        // Rute untuk Manajemen Data Bezetting Kontrak Agregat
        Route::prefix('bezetting-kontrak')->name('bezetting_kontrak.')->group(function () {
            Route::get('/', [BezettingKontrakController::class, 'index'])->name('index');
            Route::get('/create-edit', [BezettingKontrakController::class, 'createEdit'])->name('create_edit');
            Route::post('/', [BezettingKontrakController::class, 'store'])->name('store');
            Route::put('/{bezettingKontrakData}', [BezettingKontrakController::class, 'update'])->name('update');
            Route::delete('/{bezettingKontrakData}', [BezettingKontrakController::class, 'destroy'])->name('destroy');
        });
    });

    // BARU: Rute untuk Manajemen Riwayat Pegawai
    Route::prefix('pegawai/{pegawai}/riwayat')->name('pegawai.riwayat.')->group(function () {
        Route::get('/', [RiwayatPegawaiController::class, 'index'])->name('index');

        // Riwayat Golongan
        Route::post('/golongan', [RiwayatPegawaiController::class, 'storeGolongan'])->name('golongan.store');
        Route::put('/golongan/{riwayatGolongan}', [RiwayatPegawaiController::class, 'updateGolongan'])->name('golongan.update');
        Route::delete('/golongan/{riwayatGolongan}', [RiwayatPegawaiController::class, 'destroyGolongan'])->name('golongan.destroy');

        // Riwayat Jabatan
        Route::post('/jabatan', [RiwayatPegawaiController::class, 'storeJabatan'])->name('jabatan.store');
        Route::put('/jabatan/{riwayatJabatan}', [RiwayatPegawaiController::class, 'updateJabatan'])->name('jabatan.update');
        Route::delete('/jabatan/{riwayatJabatan}', [RiwayatPegawaiController::class, 'destroyJabatan'])->name('jabatan.destroy');

        // Riwayat Pendidikan
        Route::post('/pendidikan', [RiwayatPegawaiController::class, 'storePendidikan'])->name('pendidikan.store');
        Route::put('/pendidikan/{riwayatPendidikan}', [RiwayatPegawaiController::class, 'updatePendidikan'])->name('pendidikan.update');
        Route::delete('/pendidikan/{riwayatPendidikan}', [RiwayatPegawaiController::class, 'destroyPendidikan'])->name('pendidikan.destroy');
    });

    

    // Rute untuk halaman indeks laporan (yang akan menampilkan sidebar)
    Route::get('/reports', function () {
        return redirect()->route('reports.usulan-berkala.index'); // Redirect ke laporan KGB sebagai default
    })->name('reports.index');

    // Rute untuk Buku Jaga Usulan Kenaikan Gaji Berkala (KGB)
    Route::prefix('reports/usulan-berkala')->name('reports.usulan-berkala.')->group(function () {
        Route::get('/', [App\Http\Controllers\UsulanBerkalaController::class, 'index'])->name('index');
        Route::get('/export-excel', [App\Http\Controllers\UsulanBerkalaController::class, 'exportExcel'])->name('export-excel');
    });

    // Rute untuk Daftar Jaga Usulan Kenaikan Pangkat (KP)
    Route::prefix('reports/usulan-kenaikan-pangkat')->name('reports.usulan-kenaikan-pangkat.')->group(function () {
        Route::get('/', [App\Http\Controllers\UsulanKenaikanPangkatController::class, 'index'])->name('index');
        Route::get('/export-excel', [App\Http\Controllers\UsulanKenaikanPangkatController::class, 'exportExcel'])->name('export-excel');
    });
});
