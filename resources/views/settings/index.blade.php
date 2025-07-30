@extends('layouts.app')

@section('content')


<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar')
    </div>
    <div class="col-md-9">
        {{-- NEW REPORT HEADER SECTION --}}
        <div class="report-header-section mb-4">
            <div class="report-header-content">
                <h2 class="report-title">Selamat Datang di Pengaturan Sistem</h2>
            </div>
        </div>
        {{-- Tambahkan kelas 'content-card-dark' pada div.card --}}
        <div class="card shadow-sm content-card-dark">
    
            

            <div class="card-body bg-dark text-white"> {{-- Tambahkan bg-dark dan text-white pada card-body --}}
                <p>Silakan pilih opsi pengaturan dari menu di samping kiri.</p>
                <p>Di sini Anda dapat mengelola berbagai aspek sistem, mulai dari menyalin dokumen hingga mengatur data master seperti unit kerja dan jenis dokumen.</p>
                {{-- Tambahkan kelas 'dark-alert-info' pada div.alert --}}
                <div class="alert alert-info dark-alert-info">
                    <strong>Informasi:</strong> Fitur "Salin Dokumen" memungkinkan Anda untuk menyalin dokumen dari satu pegawai ke pegawai lainnya.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
