<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DokumenPegawaiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('pegawai.index');
});

// Routes untuk Manajemen Pegawai
Route::resource('pegawai', PegawaiController::class);

// Routes untuk Dokumen Pegawai
// Hanya satu route delete yang tersisa untuk penghapusan permanen
Route::delete('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'destroyPermanent'])->name('dokumen.delete');

// Route lama untuk soft delete (dokumen.destroy) telah dihapus
// Route::delete('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'destroy'])->name('dokumen.destroy');

// Route lainnya yang terkait dokumen (index, create, store, download) tetap ada
Route::get('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'index'])->name('pegawai.dokumen.index');
Route::get('pegawai/{pegawai}/dokumen/create', [DokumenPegawaiController::class, 'create'])->name('pegawai.dokumen.create');
Route::post('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'store'])->name('pegawai.dokumen.store');
Route::get('dokumen/{dokumen_pegawai}/download', [DokumenPegawaiController::class, 'download'])->name('dokumen.download');