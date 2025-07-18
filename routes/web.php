<?php

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DokumenPegawaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // Pastikan ini juga ada jika menggunakan Manajemen Pengguna
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
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('pegawai.index');
    });

    // Rute Manajemen Pegawai
    Route::resource('pegawai', PegawaiController::class);

    // Rute Manajemen Dokumen
    Route::delete('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'destroyPermanent'])->name('dokumen.delete');
    Route::get('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'index'])->name('pegawai.dokumen.index');
    Route::post('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'store'])->name('pegawai.dokumen.store');
    Route::get('dokumen/{dokumen_pegawai}/download', [DokumenPegawaiController::class, 'download'])->name('dokumen.download');

    // BARU: Rute untuk Edit Dokumen
    Route::get('dokumen/{dokumen_pegawai}/edit', [DokumenPegawaiController::class, 'edit'])->name('dokumen.edit');
    Route::put('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'update'])->name('dokumen.update');

    // Rute Manajemen Pengguna (jika Anda mengimplementasikannya)
    Route::resource('users', UserController::class); // Contoh: jika Anda menggunakan UserController

});

// Hapus atau komentari `require __DIR__.'/auth.php';` jika Anda tidak menggunakan Breeze.
// require __DIR__.'/auth.php';