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

// Route untuk Halaman Utama (bisa diarahkan ke daftar pegawai)
Route::get('/', function () {
    return redirect()->route('pegawai.index'); // Langsung arahkan ke daftar pegawai
});

// Routes untuk Manajemen Pegawai
// Tidak ada middleware 'auth' karena tidak pakai autentikasi
Route::resource('pegawai', PegawaiController::class);

// Routes untuk Manajemen Dokumen Pegawai (bersarang di bawah pegawai)
Route::get('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'index'])->name('pegawai.dokumen.index');
Route::get('pegawai/{pegawai}/dokumen/create', [DokumenPegawaiController::class, 'create'])->name('pegawai.dokumen.create');
Route::post('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'store'])->name('pegawai.dokumen.store');
Route::get('dokumen/{dokumen_pegawai}/download', [DokumenPegawaiController::class, 'download'])->name('dokumen.download');
Route::delete('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'destroy'])->name('dokumen.destroy');

// Catatan: Jika ada file `auth.php` di folder `routes`, hapus saja.