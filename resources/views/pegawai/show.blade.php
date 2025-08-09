<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Global untuk Body */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5; /* Warna latar belakang terang */
            margin: 0;
            padding: 0;
            display: flex; /* Menggunakan flexbox untuk memusatkan konten */
            justify-content: center;
            align-items: flex-start; /* Konten dimulai dari atas */
            min-height: 100vh; /* Memastikan body mengisi seluruh tinggi viewport */
        }

        /* Styling untuk container utama halaman */
        .main-container {
            background-color: #e0e7ff; /* Warna biru muda untuk latar belakang utama */
            width: 100%;
            min-height: 100vh; /* Memastikan container mengisi seluruh tinggi viewport */
            padding: 40px 20px; /* Padding keseluruhan */
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        /* Pola latar belakang di bagian atas */
        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 200px; /* Tinggi pola latar belakang */
            background: linear-gradient(135deg, #4a90e2 0%, #2e6bb8 100%); /* Gradien biru */
            z-index: 0;
        }

        /* Container untuk judul "Detail Pegawai" di tengah atas */
        .page-title-container {
            position: relative; /* Agar z-index bekerja */
            z-index: 2; /* Pastikan di atas background-pattern */
            width: 100%;
            display: flex;
            justify-content: center; /* Pindahkan ke tengah */
            padding: 20px; /* Padding dari tepi container */
            box-sizing: border-box;
            margin-bottom: 20px; /* Jarak antara judul dan konten utama */
        }

        .page-title-container h2 {
            font-size: 28px;
            font-weight: 700;
            color: white; /* Mengubah warna teks menjadi putih */
            margin: 0; /* Hapus margin default h2 */
            padding-bottom: 0; /* Hapus padding-bottom jika border-bottom dihapus */
            text-align: center; /* Pastikan teks rata tengah */
        }

        /* Wrapper untuk konten agar berada di atas pola latar belakang */
        .content-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 0; /* Sesuaikan jika page-title-container sudah memberi jarak */
        }

        /* Styling untuk setiap "kartu" informasi */
        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 25px;
        }

        /* Styling untuk sub-judul (seperti "Unggah Dokumen Baru") */
        h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        /* Container untuk detail show (flex column untuk mobile) */
        .container-detail-show {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Wrapper untuk foto profil */
        .foto-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 10px; /* Mengurangi jarak di bawah foto */
        }

        /* Styling untuk foto profil */
        .foto-profil {
            width: 200px;
            height: 200px;
            border-radius: 10%;
            object-fit: cover;
            border: 0.5px solid #515963;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Styling untuk nama pegawai di bawah foto */
        .employee-name-display {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px; /* Jarak antara nama dan grid kotak */
        }

        /* Grid untuk item-item detail pegawai */
        .grid-kotak {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        /* Styling untuk setiap item di grid detail pegawai */
        .item-kotak {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px 20px;
            display: flex;
            flex-direction: column;
            font-size: 15px;
            color: #555;
        }

        .item-kotak strong {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            font-size: 14px;
            text-transform: uppercase;
        }

        /* Styling untuk tombol kustom (Edit, Kembali) */
        .btn-custom-edit {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4a90e2;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-right: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom-edit:hover {
            background-color: #3a7bd2;
            transform: translateY(-2px);
        }

        /* Styling untuk Form Input */
        form p {
            margin-bottom: 15px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="tel"],
        form input[type="date"],
        form select,
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db; /* Border lebih terang */
            border-radius: 8px;
            font-size: 16px;
            color: #374151;
            background-color: #f9fafb; /* Latar belakang input lebih terang */
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box; /* Pastikan padding tidak menambah lebar */
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="tel"]:focus,
        form input[type="date"]:focus,
        form select:focus,
        form textarea:focus,
        form input[type="file"]:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.25);
        }

        form textarea {
            min-height: 80px;
            resize: vertical;
        }

        /* Styling untuk tombol submit form */
        form button[type="submit"] {
            padding: 12px 25px;
            background-color: #28a745; /* Warna hijau untuk submit */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form button[type="submit"]:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        /* Styling untuk Tabel Dokumen */
        .table-dokumen {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 15px;
        }

        .table-dokumen th,
        .table-dokumen td {
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
            text-align: left;
        }

        .table-dokumen th {
            background-color: #f0f2f5;
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
        }

        .table-dokumen tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-dokumen tbody tr:hover {
            background-color: #f0f7ff; /* Efek hover */
        }

        /* Tombol aksi dalam tabel */
        .table-dokumen .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            white-space: nowrap;
        }

        .table-dokumen .btn-aksi {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .table-dokumen .btn-aksi svg {
            width: 18px;
            height: 18px;
        }

        .table-dokumen .btn-lihat { background-color: #007bff; }
        .table-dokumen .btn-lihat:hover { background-color: #0056b3; transform: translateY(-1px); }

        .table-dokumen .btn-unduh { background-color: #17a2b8; }
        .table-dokumen .btn-unduh:hover { background-color: #117a8b; transform: translateY(-1px); }

        .table-dokumen .btn-rename { background-color: #ffc107; color: #333; }
        .table-dokumen .btn-rename:hover { background-color: #e0a800; transform: translateY(-1px); }

        .table-dokumen .btn-hapus { background-color: #dc3545; }
        .table-dokumen .btn-hapus:hover { background-color: #c82333; transform: translateY(-1px); }

        /* Styling untuk tombol kembali di kiri atas */
        .back-button-container {
            position: absolute; /* Posisi absolut agar bisa diatur di pojok */
            top: 20px; /* Jarak dari atas */
            left: 20px; /* Jarak dari kiri */
            z-index: 3; /* Pastikan di atas elemen lain */
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            background-color: rgba(255, 255, 255, 0.2); /* Latar belakang semi-transparan */
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .btn-back svg {
            margin-right: 8px; /* Jarak antara ikon dan teks */
        }

        /* Penyesuaian Responsif */
        @media (min-width: 992px) { /* Untuk layar yang lebih besar (desktop) */
            .grid-kotak {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
            .item-kotak.full-width {
                grid-column: 1 / -1; /* Membentang penuh di 3 kolom */
            }
        }

        @media (min-width: 769px) and (max-width: 991px) { /* Untuk tablet */
            .grid-kotak {
                grid-template-columns: repeat(2, 1fr); /* 2 kolom untuk tablet */
            }
            .item-kotak.full-width {
                grid-column: 1 / -1; /* Membentang penuh di 2 kolom */
            }
        }

        @media (max-width: 768px) { /* Untuk mobile */
            .grid-kotak {
                grid-template-columns: 1fr; /* 1 kolom untuk mobile */
            }
            .table-dokumen, .table-dokumen thead, .table-dokumen tbody, .table-dokumen th, .table-dokumen td, .table-dokumen tr {
                display: block;
            }
            .table-dokumen thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            .table-dokumen tr {
                margin-bottom: 15px;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                overflow: hidden;
            }
            .table-dokumen td {
                border: none;
                border-bottom: 1px solid #e0e0e0;
                position: relative;
                padding-left: 50%;
                text-align: right;
            }
            .table-dokumen td:before {
                position: absolute;
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: 600;
                color: #333;
            }
            .table-dokumen td:nth-of-type(1):before { content: "Jenis Dokumen"; }
            .table-dokumen td:nth-of-type(2):before { content: "Nama File Asli"; }
            .table-dokumen td:nth-of-type(3):before { content: "Versi"; }
            .table-dokumen td:nth-of-type(4):before { content: "Keterangan"; }
            .table-dokumen td:nth-of-type(5):before { content: "Status"; }
            /* Adjusted index after removing Tgl. Unggah */
            .table-dokumen td:nth-of-type(6):before { content: "TMT Dokumen"; }
            .table-dokumen td:nth-of-type(7):before { content: "Aksi"; }

            .table-dokumen .action-buttons {
                justify-content: flex-end;
                padding-right: 15px;
            }

            .back-button-container {
                top: 10px; /* Sedikit lebih kecil di mobile */
                left: 10px;
            }
        }

        /* Styles copied from index.blade.php for modal consistency */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 20px;
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        /* Profile photo styling for modals */
        .profile-photo-upload-container {
            width: 150px;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px auto;
            overflow: hidden;
            position: relative;
            background-color: #f8f9fa;
        }

        .profile-photo-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .upload-button {
            position: absolute;
            bottom: 10px;
            padding: 5px 10px;
            font-size: 0.85rem;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            color: #007bff;
        }

        .upload-button:hover {
            background-color: rgba(255, 255, 255, 1);
            color: #0056b3;
        }

        .d-block { display: block; }
        .d-flex { display: flex; }
        .justify-content-center { justify-content: center; }
        .align-items-center { align-items: center; }
        .me-1 { margin-right: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mt-2 { margin-top: 0.5rem; }
        .d-none { display: none !important; }

        /* Error messages */
        .text-red-500 { color: #dc3545; }
        .text-sm { font-size: 0.875em; }
        .mt-1 { margin-top: 0.25rem; }

        /* Form check for photo delete checkbox */
        .form-check {
            display: flex;
            align-items: center;
        }
        .form-check-input {
            margin-right: 0.25rem;
        }
        .form-check-label {
            margin-bottom: 0;
        }
        /* Additional modal styles for file rename form */
        .form-input-text, .form-select, .form-textarea, .form-input-file {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .form-input-text:focus, .form-select:focus, .form-textarea:focus, .form-input-file:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-hint {
            font-size: 0.875em;
            color: #6c757d;
            margin-top: 0.25rem;
            display: block;
        }

        .form-actions {
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }

        /* Ensure .btn-close-white works for Bootstrap modals if custom styling overrides it */
        .modal-header .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%); /* Makes it white */
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="background-pattern"></div>

        {{-- Tombol Kembali di kiri atas --}}
        <div class="back-button-container">
            <a href="{{ route('pegawai.index') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Kembali
            </a>
        </div>

        {{-- Container untuk judul "Detail Pegawai" di tengah atas --}}
        <div class="page-title-container">
            <h2 class="text-gray-800">Detail Pegawai</h2>
        </div>

        <div class="content-wrapper">
            <div class="card container-detail-show">
                <div class="foto-wrapper">
                    @if ($pegawai->foto_profil_path)
                        <img src="{{ asset($pegawai->foto_profil_path) }}" alt="Foto Profil" class="foto-profil">
                    @else
                        {{-- Menggunakan logika default dari controller yang sudah disesuaikan --}}
                        <img src="{{ asset('img/' . ($pegawai->jenis_kelamin == 'Perempuan' ? 'wanita.jpg' : 'pria.jpg')) }}" alt="Foto Profil Default" class="foto-profil">
                    @endif
                </div>

                {{-- Nama pegawai di bawah foto profil --}}
                <div class="employee-name-display">{{ $pegawai->nama_lengkap }}</div>

                <div class="grid-kotak">
                    <div class="item-kotak">
                        <strong>NIP</strong>
                        {{ $pegawai->nip }}
                    </div>
                    <div class="item-kotak">
                        <strong>NIK</strong>
                        {{ $pegawai->nik ?? '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>Nama Lengkap</strong>
                        {{ $pegawai->nama_lengkap }}
                    </div>
                    <div class="item-kotak">
                        <strong>Tanggal Lahir</strong>
                        {{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') : '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>Jenis Kelamin</strong>
                        {{ $pegawai->jenis_kelamin ?? '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>Email</strong>
                        {{ $pegawai->email ?? '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>Nomor Telepon</strong>
                        {{ $pegawai->nomor_telepon ?? '-' }}
                    </div>

                    <div class="item-kotak">
                        <strong>Golongan</strong>
                        {{ $pegawai->golongan->nama_golongan ?? '-' }} {{-- Asumsi ada relasi ke model Golongan --}}
                    </div>
                    

                    {{-- BARU: TMT (Tanggal Mulai Terhitung) --}}
                    <div class="item-kotak">
                        <strong>TMT Golongan</strong>
                        {{ $pegawai->tmt ? \Carbon\Carbon::parse($pegawai->tmt)->format('d-m-Y') : '-' }}
                    </div>

                    {{-- BARU: Eselon --}}
                    <div class="item-kotak">
                        <strong>Eselon</strong>
                        {{ $pegawai->eselon->nama_eselon ?? '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>Jabatan</strong>
                        {{ $pegawai->jabatan ?? '-' }}
                    </div>
                    {{-- PERHATIAN: Pilih salah satu untuk Pangkat dan Golongan --}}
                    {{-- Opsi 1: Jika sudah dropdown (menggunakan relasi Golongan) --}}
                    

                    {{-- BARU: Pendidikan --}}
                    <div class="item-kotak">
                        <strong>Pendidikan</strong>
                        {{ $pegawai->pendidikan->nama_pendidikan ?? '-' }}
                    </div>

                    <div class="item-kotak">
                        <strong>Bidang</strong>
                        {{ $pegawai->unit_kerja->nama_unit ?? '-' }}
                    </div>

                    <div class="item-kotak">
                        <strong>Status Pegawai</strong>
                        {{ $pegawai->status_pegawai ?? '-' }}
                    </div>

                    {{-- BARU: TMT Status --}}
                    <div class="item-kotak">
                        <strong>TMT Status</strong>
                        {{ $pegawai->tmt_status ? \Carbon\Carbon::parse($pegawai->tmt_status)->format('d-m-Y') : '-' }}
                    </div>
                    {{-- BARU: Tgl Usulan Berkala Awal --}}
                    <div class="item-kotak">
                        <strong>Tgl Usulan Berkala Awal</strong>
                        {{ $pegawai->tgl_usulan_berkala_awal ? \Carbon\Carbon::parse($pegawai->tgl_usulan_berkala_awal)->format('d-m-Y') : '-' }}
                    </div>
                    {{-- BARU: Tgl Usulan KP Awal --}}
                    <div class="item-kotak">
                        <strong>Tgl Usulan KP Awal</strong>
                        {{ $pegawai->tgl_usulan_kp_awal ? \Carbon\Carbon::parse($pegawai->tgl_usulan_kp_awal)->format('d-m-Y') : '-' }}
                    </div>

                    <div class="item-kotak full-width">
                        <strong>Alamat</strong>
                        {{ $pegawai->alamat ?? '-' }}
                    </div>
                </div>

                <div class="mt-8 flex justify-center">
                    {{-- Ubah ini untuk memicu modal --}}
                    <button type="button" class="btn-custom-edit bg-green-600 hover:bg-green-700"
                        data-bs-toggle="modal" data-bs-target="#editPegawaiModal"
                        data-id="{{ $pegawai->id }}"
                        data-nip="{{ $pegawai->nip }}"
                        data-nik="{{ $pegawai->nik ?? '' }}"
                        data-nama-lengkap="{{ $pegawai->nama_lengkap }}"
                        data-tanggal-lahir="{{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('Y-m-d') : '' }}"
                        data-jenis-kelamin="{{ $pegawai->jenis_kelamin ?? '' }}"
                        data-alamat="{{ $pegawai->alamat ?? '' }}"
                        data-email="{{ $pegawai->email ?? '' }}"
                        data-nomor-telepon="{{ $pegawai->nomor_telepon ?? '' }}"
                        data-jabatan="{{ $pegawai->jabatan ?? '' }}"
                        data-tmt="{{ \Carbon\Carbon::parse($pegawai->tmt)->format('Y-m-d') }}"
                        data-eselon-id="{{ $pegawai->eselon_id ?? '' }}"
                        data-golongan-id="{{ $pegawai->golongan_id ?? '' }}"
                        data-pendidikan-id="{{ $pegawai->pendidikan_id ?? '' }}"
                        data-unit-kerja-id="{{ $pegawai->unit_kerja_id ?? '' }}"
                        data-status-pegawai="{{ $pegawai->status_pegawai ?? '' }}"
                        data-tmt-status="{{ $pegawai->tmt_status ? \Carbon\Carbon::parse($pegawai->tmt_status)->format('Y-m-d') : '' }}"
                        data-foto-profil-path="{{ $pegawai->foto_profil_path ? asset($pegawai->foto_profil_path) : '' }}">
                        Edit Data Pegawai
                    </button>
                    {{-- BARU: Tombol untuk Manajemen Riwayat --}}
                    <a href="{{ route('pegawai.riwayat.index', $pegawai->id) }}" class="btn-custom-edit bg-green-600 hover:bg-green-700">Manajemen Riwayat</a>

                </div>
            </div>

            <div class="card container-detail-show">
                <h3>Unggah Dokumen Baru</h3>
                <form method="POST" action="{{ route('pegawai.dokumen.store', $pegawai->id) }}" enctype="multipart/form-data">
                    @csrf
                    <p>
                        <label for="jenis_dokumen_id">Jenis Dokumen:</label><br>
                        <select name="jenis_dokumen_id" id="jenis_dokumen_id" required>
                            <option value="">Pilih Jenis Dokumen</option>
                            @foreach ($jenis_dokumen as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_dokumen_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </p>
                    <p>
                        <label for="file_dokumen">File Dokumen:</label><br>
                        <input type="file" name="file_dokumen" id="file_dokumen" required>
                    </p>
                    <p>
                        <label for="tmt_dokumen">TMT Dokumen:</label><br>
                        <input type="date" name="tmt_dokumen" id="tmt_dokumen" value="{{ old('tmt_dokumen') }}">
                    </p>
                    <p>
                        <label for="keterangan">Keterangan (Asli/FotoCopy):</label><br>
                        <textarea name="keterangan" id="keterangan">{{ old('keterangan') }}</textarea>
                    </p>
                    <p>
                        <button type="submit">Unggah Dokumen</button>
                    </p>
                </form>
            </div>

            <div class="card container-detail-show">
                <h3>Daftar Semua Dokumen Pegawai (Termasuk Revisi/Non-Aktif)</h3>
                <div class="table-responsive">
                    <table class="table-dokumen">
                        <thead>
                            <tr>
                                <th>Jenis Dokumen</th>
                                <th>Nama File Asli</th>
                                <th>Versi</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                {{-- <th>Tgl. Unggah</th> Removed this column --}}
                                <th>TMT Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($all_dokumen as $doc)
                                <tr style="{{ $doc->status_dokumen == 'Revisi' ? 'background-color: #f0f0f0;' : '' }}">
                                    <td>{{ $doc->jenis_dokumen->nama_jenis ?? '-' }}</td>
                                    <td>{{ $doc->nama_file_asli }}</td>
                                    <td>{{ $doc->versi_dokumen }}</td>
                                    <td>{{ $doc->keterangan ?? '-' }}</td>
                                    <td>
                                        <strong>{{ $doc->status_dokumen }}</strong>
                                    </td>
                                    {{-- <td>{{ $doc->tanggal_upload->format('d-m-Y H:i') }}</td> Removed this data cell --}}
                                    <td>{{ $doc->tmt_dokumen ? \Carbon\Carbon::parse($doc->tmt_dokumen)->format('d-m-Y') : '-' }}</td>
                                    <td class="action-buttons">
                                        {{-- Tombol Lihat --}}
                                        @php
                            $fileUrl = Storage::url($doc->path_file);
                            $extension = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
                        @endphp
                        
                        @if(in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']))
                            {{-- Jika PDF atau gambar, buka langsung --}}
                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="btn-aksi btn-lihat" title="Lihat Dokumen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </a>
                        @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx']))
                            {{-- Jika Word/Excel, buka pakai Google Docs Viewer --}}
                            <a href="https://docs.google.com/gview?url={{ urlencode($fileUrl) }}&embedded=true" target="_blank" rel="noopener noreferrer" class="btn-aksi btn-lihat" title="Lihat Dokumen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </a>
                        @else
                            {{-- Jika format lain, default: download --}}
                            <a href="{{ $fileUrl }}" download class="btn-aksi btn-lihat" title="Download Dokumen">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9V12a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1V9.9a.5.5 0 0 0-1 0V12H1v-2.1a.5.5 0 0 0-1 0z"/>
                                    <path d="M7.646 10.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 9.293V1.5a.5.5 0 0 0-1 0v7.793L5.354 7.146a.5.5 0 1 0-.708.708l3 3z"/>
                                </svg>
                            </a>
                        @endif
    
    
                                        {{-- Tombol Unduh --}}
                                        <a href="{{ route('dokumen.download', $doc->id) }}" target="_blank" class="btn-aksi btn-unduh" title="Unduh Dokumen">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.6a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5V10.4a.5.5 0 0 1 1 0v2.6a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13V10.4a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M7.646 10.854a.5.5 0 0 0 .708 0L11 8.207V1.5a.5.5 0 0 0-1 0v6.793L8.354 5.146a.5.5 0 1 0-.708.708L10.293 9H6.707l2.647-2.646a.5.5 0 0 0-.708-.708L5 9.793 7.646 10.854z"/>
                                            </svg>
                                        </a>
    
                                        {{-- Tombol Rename (Trigger Modal) --}}
                                        <button type="button" class="btn-aksi btn-rename" title="Rename Dokumen"
                                            data-bs-toggle="modal" data-bs-target="#renameFileModal"
                                            data-id="{{ $doc->id }}"
                                            data-nama-file-asli="{{ $doc->nama_file_asli }}"
                                            data-jenis-dokumen-id="{{ $doc->jenis_dokumen_id }}"
                                            data-keterangan="{{ $doc->keterangan ?? '' }}"
                                            data-versi="{{ $doc->versi_dokumen }}"
                                            data-pegawai-nama="{{ $pegawai->nama_lengkap }}"
                                            data-pegawai-nip="{{ $pegawai->nip }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 1 .707 0l2.293 2.293a.5.5 0 0 1 0 .707l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5zM11.207 2.5 13.5 4.793 12.5 5.793 10.207 3.5 11.207 2.5zm1.586 3L10.5 3.207l-8.646 8.647-.854 2.146 2.146-.854L12.793 5.5z"/>
                                            </svg>
                                        </button>
    
                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('dokumen.delete', $doc->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('PERINGATAN! Anda akan menghapus dokumen ini secara PERMANEN. Lanjutkan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-aksi btn-hapus" title="Hapus Dokumen">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Tidak ada dokumen aktif atau revisi untuk pegawai ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <footer class="text-center mt-5 mb-3 text-muted" style="font-size: 14px;">
    © 2025 Sistem Informasi Kepegawaian - Dikelola oleh Bagian Kepegawaian
</footer>

    </div>

    {{-- NEW: MODAL EDIT PEGAWAI (SALIN DARI INDEX.BLADE.PHP) --}}
    <div class="modal fade" id="editPegawaiModal" tabindex="-1" aria-labelledby="editPegawaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPegawaiModalLabel">Edit Data Pegawai</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPegawaiForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Hidden input to store redirect URL --}}
                        <input type="hidden" name="_redirect_to" value="{{ request()->fullUrl() }}">

                        {{-- Foto Profil di Tengah (gaya baru untuk edit) --}}
                        <div class="form-group text-center mb-4">
                            <label for="modal_edit_foto_profil" class="d-block mb-2">Foto Profil:</label>
                            <div class="profile-photo-upload-container">
                                <img id="modal-edit-profile-preview-image" src="{{ asset('img/no-photo.jpg') }}" alt="No Photo" class="profile-photo-preview">
                                <button type="button" id="modal-edit-upload-new-button" class="btn btn-sm btn-outline-primary upload-button">Upload New</button>
                                <input type="file" name="foto_profil" id="modal_edit_foto_profil" class="d-none">
                            </div>
                            <div class="form-check d-flex justify-content-center align-items-center mt-2">
                                <input class="form-check-input me-1" type="checkbox" name="hapus_foto_profil" value="1" id="modal_edit_hapus_foto_profil">
                                <label class="form-check-label" for="modal_edit_hapus_foto_profil">
                                    Hapus Foto Profil Saat Ini
                                </label>
                            </div>
                            @error('foto_profil')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <p class="form-group">
                                <label for="modal_edit_nip">NIP:</label>
                                <input type="text" name="nip" id="modal_edit_nip" required>
                                @error('nip')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>

                            <p class="form-group">
                                <label for="modal_edit_nik">NIK:</label>
                                <input type="text" name="nik" id="modal_edit_nik">
                                @error('nik')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>

                            <p class="form-group">
                                <label for="modal_edit_nama_lengkap">Nama Lengkap:</label>
                                <input type="text" name="nama_lengkap" id="modal_edit_nama_lengkap" required>
                                @error('nama_lengkap')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>

                            <p class="form-group">
                                <label for="modal_edit_tanggal_lahir">Tanggal Lahir:</label>
                                <input type="date" name="tanggal_lahir" id="modal_edit_tanggal_lahir">
                                @error('tanggal_lahir')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>

                            <p class="form-group">
                                <label for="modal_edit_jenis_kelamin">Jenis Kelamin:</label>
                                <select name="jenis_kelamin" id="modal_edit_jenis_kelamin">
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>

                            <p class="form-group">
                                <label for="modal_edit_email">Email:</label>
                                <input type="email" name="email" id="modal_edit_email">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>

                            <p class="form-group">
                                <label for="modal_edit_unit_kerja_id">Bidang:</label>
                                <select name="unit_kerja_id" id="modal_edit_unit_kerja_id">
                                    <option value="">Pilih Bidang</option>
                                    {{-- Pastikan $unitKerjaList tersedia di show() method controller --}}
                                    @foreach ($unitKerjaList as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                                    @endforeach
                                </select>
                                @error('unit_kerja_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>
                        

                            <p class="form-group">
                                <label for="modal_edit_jabatan">Jabatan:</label>
                                <input type="text" name="jabatan" id="modal_edit_jabatan">
                                @error('jabatan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>

                            {{-- Dropdown untuk Eselon --}}
                            <p class="form-group">
                                <label for="modal_edit_eselon_id">Eselon:</label>
                                <select name="eselon_id" id="modal_edit_eselon_id" required>
                                    <option value="">Pilih Eselon</option>
                                    {{-- Pastikan $eselons tersedia di show() method controller --}}
                                    @foreach ($eselons as $eselon)
                                        <option value="{{ $eselon->id }}">{{ $eselon->nama_eselon }}</option>
                                    @endforeach
                                </select>
                                @error('eselon_id') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </p>

                            {{-- Dropdown untuk Pendidikan --}}
                            <p class="form-group">
                                <label for="modal_edit_pendidikan_id">Pendidikan:</label>
                                <select name="pendidikan_id" id="modal_edit_pendidikan_id">
                                    <option value="">Pilih Pendidikan</option>
                                    {{-- Pastikan $pendidikans tersedia di show() method controller --}}
                                    @foreach ($pendidikans as $pendidikan)
                                        <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
                                    @endforeach
                                </select>
                                @error('pendidikan_id') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </p>

                            {{-- Dropdown untuk Pangkat dan Golongan --}}
                            <p class="form-group">
                                <label for="modal_edit_golongan_id">Golongan:</label>
                                <select name="golongan_id" id="modal_edit_golongan_id">
                                    <option value="">Pilih Golongan</option>
                                    {{-- Pastikan $golongans tersedia di show() method controller --}}
                                    @foreach ($golongans as $golongan)
                                        <option value="{{ $golongan->id }}">{{ $golongan->nama_golongan }}</option>
                                    @endforeach
                                </select>
                                @error('golongan_id') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </p>

                            {{-- Input untuk TMT (Tanggal Mulai Terhitung) --}}
                            <p class="form-group">
                                <label for="modal_edit_tmt">TMT Golongan:</label>
                                <input type="date" name="tmt" id="modal_edit_tmt">
                                @error('tmt') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </p>

                            <p class="form-group">
                                <label for="modal_edit_status_pegawai">Status Pegawai:</label>
                                <select name="status_pegawai" id="modal_edit_status_pegawai">
                                    <option value="">Pilih</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non-aktif">Non-aktif</option>
                                    <option value="Pensiun">Pensiun</option>
                                </select>
                                @error('status_pegawai')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>

                            {{-- Input untuk TMT Status --}}
                            <p class="form-group">
                                <label for="modal_edit_tmt_status">TMT Status:</label>
                                <input type="date" name="tmt_status" id="modal_edit_tmt_status">
                                @error('tmt_status') <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </p>

                            <p class="form-group">
                                <label for="modal_edit_nomor_telepon">Nomor Telepon:</label>
                                <input type="text" name="nomor_telepon" id="modal_edit_nomor_telepon">
                                @error('nomor_telepon')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </p>
                            
                        </div>

                        <p>
                            <label for="modal_edit_alamat">Alamat:</label>
                            <textarea name="alamat" id="modal_edit_alamat"></textarea>
                            @error('alamat')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </p>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Perbarui Pegawai</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- NEW: Modal for Rename File (already exists, but included for completeness) --}}
    <div class="modal fade" id="renameFileModal" tabindex="-1" aria-labelledby="renameFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameFileModalLabel">Edit Dokumen</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center p-3 mb-4 rounded shadow-sm" style="background-color: #f9fafb;">
                        <i class="bi bi-person-badge-fill fs-3 text-primary me-3"></i>
                        <div>
                            <div class="fw-semibold text-dark" id="modalEmployeeName"></div>
                            <small class="text-muted" id="modalEmployeeNIP"></small>
                        </div>
                    </div>

                    <form id="renameDocumentForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- PENTING: Untuk metode UPDATE --}}

                        <div class="form-group mb-3">
                            <label for="modal_nama_file_asli">Nama File Dokumen:</label>
                            <input type="text" name="nama_file_asli" id="modal_nama_file_asli" class="form-input-text" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="modal_jenis_dokumen_id">Jenis Dokumen:</label>
                            <select name="jenis_dokumen_id" id="modal_jenis_dokumen_id" class="form-select" required>
                                <option value="">Pilih Jenis Dokumen</option>
                                @foreach ($jenis_dokumen as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="modal_keterangan">Keterangan (Opsional):</label>
                            <textarea name="keterangan" id="modal_keterangan" class="form-textarea"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="modal_file_dokumen">Upload File Baru (untuk membuat versi baru):</label>
                            <input type="file" name="file_dokumen" id="modal_file_dokumen" class="form-input-file">
                            <small class="form-hint">
                                Kosongkan jika hanya ingin mengubah detail dokumen. Jika diisi, akan menjadi V<span id="modal_next_version"></span> dan menggantikan versi aktif saat ini.
                            </small>
                        </div>
                        <div class="form-group mb-3" id="modal_current_file_link_container" style="display: none;">
                            <p class="form-hint mb-2">File saat ini:</p>
                            <a href="#" target="_blank" id="modal_current_file_link"
                            class="btn btn-primary">
                            🔍 Lihat File Saat Ini V<span id="modal_current_version_display"></span>
                            </a>
                        </div>

                        <div class="form-actions mb-3 d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Perbarui Dokumen</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Define JavaScript variables for asset paths
            const defaultPriaPhoto = "{{ asset('img/pria.jpg') }}";
            const defaultWanitaPhoto = "{{ asset('img/wanita.jpg') }}";
            const noPhoto = "{{ asset('img/no-photo.jpg') }}";

            // Script for Rename File Modal (already existing)
            const renameFileModal = document.getElementById('renameFileModal');
            renameFileModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const documentId = button.getAttribute('data-id');
                const namaFileAsli = button.getAttribute('data-nama-file-asli');
                const jenisDokumenId = button.getAttribute('data-jenis-dokumen-id');
                const keterangan = button.getAttribute('data-keterangan');
                const versi = parseInt(button.getAttribute('data-versi'));
                const pegawaiNama = button.getAttribute('data-pegawai-nama');
                const pegawaiNip = button.getAttribute('data-pegawai-nip');
                const currentFilePath = button.closest('tr').querySelector('.btn-lihat').getAttribute('href');

                const modalTitle = renameFileModal.querySelector('.modal-title');
                const form = renameFileModal.querySelector('#renameDocumentForm');
                const inputNamaFileAsli = renameFileModal.querySelector('#modal_nama_file_asli');
                const selectJenisDokumen = renameFileModal.querySelector('#modal_jenis_dokumen_id');
                const textareaKeterangan = renameFileModal.querySelector('#modal_keterangan');
                const modalNextVersionSpan = renameFileModal.querySelector('#modal_next_version');
                const modalCurrentVersionDisplay = renameFileModal.querySelector('#modal_current_version_display');
                const modalCurrentFileLink = renameFileModal.querySelector('#modal_current_file_link');
                const modalCurrentFileLinkContainer = renameFileModal.querySelector('#modal_current_file_link_container');
                const modalEmployeeName = renameFileModal.querySelector('#modalEmployeeName');
                const modalEmployeeNIP = renameFileModal.querySelector('#modalEmployeeNIP');

                modalTitle.textContent = `Edit Dokumen: ${namaFileAsli}`;
                modalEmployeeName.textContent = pegawaiNama;
                modalEmployeeNIP.textContent = `NIP: ${pegawaiNip}`;
                form.action = `/dokumen/${documentId}`;

                inputNamaFileAsli.value = namaFileAsli;
                selectJenisDokumen.value = jenisDokumenId;
                textareaKeterangan.value = keterangan;
                modalNextVersionSpan.textContent = versi + 1;
                modalCurrentVersionDisplay.textContent = versi;

                if (currentFilePath) {
                    modalCurrentFileLink.href = currentFilePath;
                    modalCurrentFileLinkContainer.style.display = 'block';
                } else {
                    modalCurrentFileLinkContainer.style.display = 'none';
                }
            });


            // NEW: Script for Edit Employee Modal (Copied from index.blade.php)
            const editPegawaiModal = document.getElementById('editPegawaiModal');
            if (editPegawaiModal) {
                const editFileInput = document.getElementById('modal_edit_foto_profil');
                const editPreviewImage = document.getElementById('modal-edit-profile-preview-image');
                const editUploadButton = document.getElementById('modal-edit-upload-new-button');
                const editHapusFotoProfilCheckbox = document.getElementById('modal_edit_hapus_foto_profil');

                editPegawaiModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;

                    // Ambil semua data dari data-* attributes
                    const id = button.getAttribute('data-id');
                    const nip = button.getAttribute('data-nip');
                    const nik = button.getAttribute('data-nik');
                    const namaLengkap = button.getAttribute('data-nama-lengkap');
                    const tanggalLahir = button.getAttribute('data-tanggal-lahir');
                    const jenisKelamin = button.getAttribute('data-jenis-kelamin');
                    const alamat = button.getAttribute('data-alamat');
                    const email = button.getAttribute('data-email');
                    const nomorTelepon = button.getAttribute('data-nomor-telepon');
                    const jabatan = button.getAttribute('data-jabatan');
                    const tmt = button.getAttribute('data-tmt');
                    const eselonId = button.getAttribute('data-eselon-id');
                    const golonganId = button.getAttribute('data-golongan-id');
                    const pendidikanId = button.getAttribute('data-pendidikan-id');
                    const unitKerjaId = button.getAttribute('data-unit-kerja-id');
                    const statusPegawai = button.getAttribute('data-status-pegawai');
                    const tmtStatus = button.getAttribute('data-tmt-status');
                    const fotoProfilPath = button.getAttribute('data-foto-profil-path');

                    // Update the modal's content.
                    const modalTitle = editPegawaiModal.querySelector('.modal-title');
                    const form = editPegawaiModal.querySelector('#editPegawaiForm');

                    // Set modal title and form action
                    modalTitle.textContent = `Edit Data Pegawai: ${namaLengkap}`;
                    form.action = `/pegawai/${id}`; // Sesuaikan route Laravel Anda

                    // Populate form fields
                    editPegawaiModal.querySelector('#modal_edit_nip').value = nip;
                    editPegawaiModal.querySelector('#modal_edit_nik').value = nik;
                    editPegawaiModal.querySelector('#modal_edit_nama_lengkap').value = namaLengkap;
                    editPegawaiModal.querySelector('#modal_edit_tanggal_lahir').value = tanggalLahir;
                    editPegawaiModal.querySelector('#modal_edit_jenis_kelamin').value = jenisKelamin;
                    editPegawaiModal.querySelector('#modal_edit_alamat').value = alamat;
                    editPegawaiModal.querySelector('#modal_edit_email').value = email;
                    editPegawaiModal.querySelector('#modal_edit_nomor_telepon').value = nomorTelepon;
                    editPegawaiModal.querySelector('#modal_edit_jabatan').value = jabatan;

                    // Isi dropdown dengan ID yang diambil
                    editPegawaiModal.querySelector('#modal_edit_tmt').value = tmt;
                    editPegawaiModal.querySelector('#modal_edit_eselon_id').value = eselonId;
                    editPegawaiModal.querySelector('#modal_edit_golongan_id').value = golonganId;
                    editPegawaiModal.querySelector('#modal_edit_pendidikan_id').value = pendidikanId;
                    editPegawaiModal.querySelector('#modal_edit_unit_kerja_id').value = unitKerjaId;
                    editPegawaiModal.querySelector('#modal_edit_status_pegawai').value = statusPegawai;
                    editPegawaiModal.querySelector('#modal_edit_tmt_status').value = tmtStatus;

                    // Handle photo preview for EDIT MODAL
                    if (fotoProfilPath && fotoProfilPath !== defaultPriaPhoto && fotoProfilPath !== defaultWanitaPhoto) {
                        editPreviewImage.src = fotoProfilPath;
                        editPreviewImage.dataset.originalSrc = fotoProfilPath;
                    } else {
                        const defaultGenderPhoto = (jenisKelamin === 'Perempuan') ? defaultWanitaPhoto : defaultPriaPhoto;
                        editPreviewImage.src = defaultGenderPhoto;
                        editPreviewImage.dataset.originalSrc = defaultGenderPhoto;
                    }
                    editHapusFotoProfilCheckbox.checked = false;
                    editFileInput.value = '';
                });

                // Event listener for "Upload New" button in Edit Modal
                editUploadButton.addEventListener('click', function() {
                    editFileInput.click();
                });

                // Event listener for file input change in Edit Modal
                editFileInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            editPreviewImage.src = e.target.result;
                            if (editHapusFotoProfilCheckbox) {
                                editHapusFotoProfilCheckbox.checked = false;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Event listener for "Hapus Foto Profil" checkbox in Edit Modal
                if (editHapusFotoProfilCheckbox) {
                    editHapusFotoProfilCheckbox.addEventListener('change', function() {
                        if (this.checked) {
                            editPreviewImage.src = noPhoto;
                            editFileInput.value = '';
                        } else {
                            editPreviewImage.src = editPreviewImage.dataset.originalSrc || noPhoto;
                        }
                    });
                }

                // Reset the image and checkbox when the modal is hidden
                editPegawaiModal.addEventListener('hidden.bs.modal', function() {
                    editPreviewImage.src = noPhoto;
                    editFileInput.value = '';
                    if (editHapusFotoProfilCheckbox) {
                        editHapusFotoProfilCheckbox.checked = false;
                    }
                });

            }

            @if ($errors->any() && session('modal_target') == 'editPegawaiModal')
                    var editModal = new bootstrap.Modal(document.getElementById('editPegawaiModal'));
                    editModal.show();
                @endif
        });
    </script>
</body>
</html>
