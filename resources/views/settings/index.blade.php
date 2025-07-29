@extends('layouts.app')

@section('content')

<style>
    /* --- Styling untuk Konten Utama (Selamat Datang Card) --- */
.content-card-dark {
    background: linear-gradient(135deg, #4a90e2 0%, #2e6bb8 100%); /* Latar belakang hitam, sesuai sidebar */
    color: #f8f9fa; /* Warna teks default putih/abu terang untuk konten ini */
    border: none; /* Hilangkan border */
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; /* Bayangan serupa dengan sidebar */
    border-radius: 8px; /* Sudut melengkung, sesuaikan dengan sidebar jika berbeda */
    overflow: hidden; /* Penting untuk memastikan border-radius terlihat sempurna */
}

.content-card-dark .card-header {
    background: linear-gradient(135deg, #4a90e2 0%, #2e6bb8 100%); /* Latar belakang header juga hitam */
    border-bottom: none; /* Pastikan tidak ada border di bawah header */
    color: #f8f9fa; /* Warna teks header */
    padding-bottom: 0.5rem; /* Sesuaikan padding jika perlu */
    /* Untuk memastikan sudut atas header juga melengkung */
    border-top-left-radius: inherit;
    border-top-right-radius: inherit;
}

.content-card-dark .card-body {
    /* Menambahkan ini untuk memastikan border-radius juga diterapkan pada card-body */
    border-bottom-left-radius: inherit;
    border-bottom-right-radius: inherit;
    /* Pastikan background-color di sini sesuai dengan yang diinginkan (bg-dark dari Blade) */
    /* Jika Anda ingin background-color diatur di CSS, Anda bisa tambahkan:
       background-color: #212529;
    */
}


.content-card-dark .card-title {
    color: #f8f9fa; /* Pastikan judul juga putih */
}

/* Styling untuk bagian Informasi (alert) di tema gelap */
.dark-alert-info {
    /* Warna latar belakang yang lebih gelap dari default alert-info */
    color: #7b8796; /* Warna teks yang lebih terang agar terbaca di latar gelap */
    border-color: #4a5568; /* Warna border yang lebih gelap */
    
}

.dark-alert-info strong {
    color: #000; /* Pastikan teks "Informasi:" tetap putih */
}

/* --- Override default Bootstrap card styles if necessary for consistency --- */
/* Ini adalah aturan umum untuk semua .card dan .card-header.
   Pastikan ini tidak bertentangan dengan desain lain di aplikasi Anda. */
.card {
    border-radius: 8px; /* Memastikan semua kartu memiliki sudut melengkung */
    border: none; /* Menghilangkan border default kartu */
}

.card-header {
    background-color: transparent; /* Default ke transparan kecuali ditentukan lain */
    border-bottom: 1px solid rgba(0,0,0,.125); /* Border default Bootstrap */
}

</style>
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
