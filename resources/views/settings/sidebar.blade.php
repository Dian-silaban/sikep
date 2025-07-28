{{-- resources/views/settings/sidebar.blade.php --}}
<style>
/* public/css/custom.css */

/* Pastikan container utama Anda juga mendukung tinggi penuh */
html, body, #app {
    height: 100%;
    margin: 0;
    overflow-x: hidden;
}

.wrapper { /* Contoh wrapper utama yang membungkus sidebar dan konten */
    display: flex;
    min-height: 100vh; /* Agar wrapper setidaknya setinggi viewport */
}

/* --- Styling untuk Sidebar --- */
.sidebar-wrapper {
    width: 340px; /* Lebar sidebar tetap, sesuaikan jika perlu */
    min-width: 280px; /* Mencegah sidebar menyusut */
    background-color: #212529; /* Latar belakang gelap */
    color: #f8f9fa; /* Warna teks default sidebar */
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    border: none;
    border-radius: 8px; /* Sudut melengkung pada wrapper */
    display: flex;
    flex-direction: column; /* Pastikan konten di dalam card disusun vertikal */
    overflow: hidden; /* <--- INI PENTING! Memastikan border-radius terlihat sempurna */
}

.sidebar-wrapper .card-body {
    padding: 0;
    display: flex; /* Ini membuat card-body menjadi flex container */
    flex-direction: column; /* Konten di dalam card-body ditumpuk vertikal */
    height: 100%; /* Penting agar card-body bisa memanjang dalam sidebar-wrapper */
    /* Opsional: Jika Anda ingin card-body juga memiliki radius agar lebih eksplisit,
       Anda bisa tambahkan 'border-radius: inherit;' di sini, meskipun overflow: hidden;
       pada parent seharusnya sudah cukup. */
}

/* Styling Header Sidebar (jika Anda menambahkannya di Blade) */
.sidebar-header {
    background-color: #1a1e22; /* Warna latar belakang header lebih gelap */
    color: #fff;
    font-weight: bold;
    padding: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    /* Penting: Pastikan sudut atas header juga melengkung sesuai wrapper */
    border-top-left-radius: inherit;
    border-top-right-radius: inherit;
}

.sidebar-nav {
    padding: 10px 12px; /* Padding vertikal untuk keseluruhan menu */
    list-style: none;
    margin: 0;
    margin-bottom: 280px;
    /* TIDAK ADA flex-grow-1 di sini lagi */
}

.sidebar-nav .nav-item {
    margin-bottom: 2px;
}

.sidebar-nav .nav-link {
    padding: 12px 20px;
    color: #f8f9fa; /* Warna teks default untuk item menu non-aktif (putih) */
    font-weight: 500;
    border-radius: 0; /* Biarkan 0 jika Anda tidak ingin item menu melengkung */
    transition: all 0.2s ease-in-out;
    display: flex;
    align-items: center;
    text-decoration: none;
}

.sidebar-nav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.08); /* Latar belakang saat hover */
    color: #fff; /* Warna teks saat hover */
}

.sidebar-nav .nav-link.active {
    background-color: #0d6efd; /* Warna latar belakang item aktif (biru Bootstrap primary) */
    color: #fff; /* Warna teks untuk item aktif */
    box-shadow: none;
    border-left: 4px solid #0dcaf0; /* Contoh border indikator aktif */
    padding-left: 16px;
    border-radius: 8px;
    
    /* Jika Anda ingin item aktif memiliki border-radius juga, tambahkan di sini */
    /* border-radius: 4px; */
}

.sidebar-nav .nav-link.active i {
    color: #fff; /* Warna ikon untuk item aktif */
}

.sidebar-nav i {
    font-size: 1.1em;
    width: 25px;
    text-align: center;
    color: #adb5bd; /* Warna ikon default untuk item non-aktif. Ubah ke #fff jika ingin putih. */
}

/* Spacer yang akan mengisi ruang kosong */
.sidebar-spacer {
    flex-grow: 1; /* Penting agar spacer mengisi sisa ruang */
}

/* --- Styling untuk Tombol Kembali di Bagian Bawah Sidebar --- */
.sidebar-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1); /* Garis pemisah */
    padding: 15px 20px; /* Padding di sekitar tombol */
    background-color: #212529; /* Pastikan latar belakang sama dengan sidebar */
    /* Penting: Pastikan sudut bawah juga melengkung sesuai wrapper */
    border-bottom-left-radius: inherit;
    border-bottom-right-radius: inherit;
}

.sidebar-return-btn {
    background-color: #0d6efd; /* Warna latar belakang primary */
    border-color: #0d6efd; /* Warna border primary */
    color: #fff;
    font-weight: 600;
    padding: 10px 15px; /* Padding tombol, sesuaikan jika perlu */
    border-radius: 8px; /* Sudut melengkung untuk tombol */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease-in-out;
}

.sidebar-return-btn:hover {
    background-color: #0a58ca; /* Warna primary sedikit lebih gelap saat hover */
    border-color: #0a58ca; /* Warna border primary sedikit lebih gelap saat hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}
.sidebar-return-btn i {
    color: #fff; /* Pastikan ikon putih */
}

</style>

{{-- resources/views/settings/sidebar.blade.php --}}
<div class="card shadow-sm sidebar-wrapper">
    <div class="card-body p-0 d-flex flex-column"> {{-- d-flex flex-column untuk flexbox vertikal --}}

        {{-- Logo atau Header Sidebar jika ada (opsional, uncomment jika digunakan) --}}
        {{-- <div class="sidebar-header p-4 pb-2">
            <h5 class="mb-0 text-white">SIKEP BPKAD</h5>
        </div> --}}

        <ul class="nav flex-column sidebar-nav"> {{-- Hapus flex-grow-1 dari sini --}}
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ request()->routeIs('settings.document_migration.*') ? 'active' : '' }}"
                   href="{{ route('settings.document_migration.index') }}">
                    <i class="fas fa-file-alt me-3"></i>
                    Salin Dokumen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ request()->routeIs('settings.unit-kerja.*') ? 'active' : '' }}"
                   href="{{ route('settings.unit-kerja.index') }}">
                    <i class="fas fa-building me-3"></i>
                    Manajemen Unit Kerja
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ request()->routeIs('settings.jenis-dokumen.*') ? 'active' : '' }}"
                   href="{{ route('settings.jenis-dokumen.index') }}">
                    <i class="fas fa-folder-open me-3"></i>
                    Manajemen Dokumen
                </a>
            </li>
            {{-- Tambahkan menu lain di sini --}}
        </ul>

        {{-- Spacer yang akan mengisi ruang kosong dan mendorong tombol ke bawah --}}
        <div class="sidebar-spacer flex-grow-1"></div>

        {{-- Tombol Kembali ke Pengaturan Awal --}}
        <div class="sidebar-bottom p-3 pb-4"> {{-- Tambahkan pb-4 untuk padding bawah tambahan --}}
            <a href="{{ route('settings.index') }}" class="btn btn-dark w-100 sidebar-return-btn rounded mb-2"> {{-- Tambahkan rounded dan mb-2 untuk margin bawah --}}
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Pengaturan Awal
            </a>
            {{-- Tombol Kembali ke Daftar Pegawai (Halaman Utama) --}}
            <a href="{{ route('pegawai.index') }}" class="btn btn-dark w-100 sidebar-return-btn rounded"> {{-- Ganti 'pegawai.index' dengan route halaman utama Anda --}}
                <i class="fas fa-users me-2"></i> Kembali ke Daftar Pegawai
            </a>
        </div>
    </div>
</div>
