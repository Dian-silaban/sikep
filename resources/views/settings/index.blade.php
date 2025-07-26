@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar')
    </div>
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Selamat Datang di Pengaturan Sistem</h5>
            </div>
            <div class="card-body">
                <p>Silakan pilih opsi pengaturan dari menu di samping kiri.</p>
                <p>Di sini Anda dapat mengelola berbagai aspek sistem, mulai dari menyalin dokumen hingga mengatur data master seperti unit kerja dan jenis dokumen.</p>
                <div class="alert alert-info">
                    <strong>Informasi:</strong> Fitur "Salin Dokumen" memungkinkan Anda untuk menyalin dokumen dari satu pegawai ke pegawai lainnya.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection