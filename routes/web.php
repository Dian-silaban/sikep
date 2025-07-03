<?php

use App\Http\Controllers\ProfileController;  
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DokumenPegawaiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('pegawai.index');
});

Route::middleware('auth')->group(function () {
    Route::resource('pegawai', PegawaiController::class);

    Route::delete('dokumen/{dokumen_pegawai}', [DokumenPegawaiController::class, 'destroyPermanent'])->name('dokumen.delete');
    Route::get('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'index'])->name('pegawai.dokumen.index');
    Route::post('pegawai/{pegawai}/dokumen', [DokumenPegawaiController::class, 'store'])->name('pegawai.dokumen.store');
    Route::get('dokumen/{dokumen_pegawai}/download', [DokumenPegawaiController::class, 'download'])->name('dokumen.download');

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', function (Request $request) {
    Auth::logout(); // Mengakhiri sesi pengguna

    $request->session()->invalidate(); // Membatalkan sesi saat ini
    $request->session()->regenerateToken(); // Meregenerasi token CSRF

    return redirect('/'); // Mengarahkan ke halaman utama setelah logout
})->name('logout');
});

require __DIR__.'/auth.php';

