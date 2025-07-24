<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pegawai</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Global CSS for Body */
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

        /* Styling for the main page container */
        .main-container {
            background-color: #e0e7ff; /* Warna biru muda untuk latar belakang utama */
            width: 100%;
            min-height: 100vh; /* Memastikan container mengisi seluruh tinggi viewport */
            padding: 40px 20px; /* Padding keseluruhan */
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        /* Background pattern at the top */
        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 200px; /* Height of the background pattern */
            background: linear-gradient(135deg, #4a90e2 0%, #2e6bb8 100%); /* Blue gradient */
            clip-path: polygon(0 0, 100% 0, 100% 70%, 0% 100%); /* Geometric pattern shape */
            z-index: 0;
        }

        /* Container for the "Tambah Pegawai Baru" title in the top center */
        .page-title-container {
            position: relative; /* For z-index to work */
            z-index: 2; /* Ensure it's above the background-pattern */
            width: 100%;
            display: flex;
            justify-content: center; /* Center the title */
            padding: 20px; /* Padding from container edges */
            box-sizing: border-box;
            margin-bottom: 20px; /* Space between title and main content */
        }

        .page-title-container h2 {
            font-size: 28px;
            font-weight: 700;
            color: white; /* Change text color to white */
            margin: 0; /* Remove default h2 margin */
            padding-bottom: 0; /* Remove padding-bottom if border-bottom is removed */
            text-align: center; /* Ensure text is centered */
        }

        /* Wrapper for content to be above the background pattern */
        .content-wrapper {
            position: relative;
            z-index: 1;
            max-width: 800px; /* Max width for the form container */
            margin: 0 auto;
            padding: 20px;
            margin-top: 0; /* Adjust if page-title-container already provides spacing */
        }

        /* Styling for the form card */
        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 25px;
        }

        /* Styling for sub-headings (e.g., "Upload New Document") */
        h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Styling */
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
            border: 1px solid #d1d5db; /* Lighter border */
            border-radius: 8px;
            font-size: 16px;
            color: #374151;
            background-color: #f9fafb; /* Lighter input background */
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box; /* Ensure padding doesn't add to width */
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

        /* Styling for form submit button */
        form button[type="submit"] {
            padding: 12px 25px;
            background-color: #28a745; /* Green color for submit */
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

        /* Styling for custom buttons (e.g., Cancel) */
        .btn-custom {
            display: inline-block;
            padding: 12px 25px;
            background-color: #6b7280; /* Gray color for cancel */
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-left: 10px; /* Space from submit button */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom:hover {
            background-color: #4b5563;
            transform: translateY(-2px);
        }

        /* Styling for back button in top left */
        .back-button-container {
            position: absolute; /* Absolute positioning to place in corner */
            top: 20px; /* Distance from top */
            left: 20px; /* Distance from left */
            z-index: 3; /* Ensure it's above other elements */
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent background */
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
            margin-right: 8px; /* Space between icon and text */
        }

        /* New CSS for two-column form layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two equal columns */
            gap: 20px; /* Gap between columns and rows */
        }

        .form-grid .form-group {
            margin-bottom: 0; /* Remove default paragraph margin if using form-group */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .back-button-container {
                top: 10px; /* Slightly smaller on mobile */
                left: 10px;
            }
            .page-title-container {
                padding: 10px;
            }
            .page-title-container h2 {
                font-size: 24px;
            }
            .content-wrapper {
                padding: 10px;
            }
            .card {
                padding: 20px;
            }
            form input, form select, form textarea, form button, .btn-custom {
                font-size: 14px;
                padding: 10px 12px;
            }
            .form-grid {
                grid-template-columns: 1fr; /* Single column on small screens */
            }
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

        {{-- Container untuk judul "Tambah Pegawai Baru" di tengah atas --}}
        <div class="page-title-container">
            <h2 class="text-gray-800">Tambah Pegawai Baru</h2>
        </div>

        <div class="content-wrapper">
            <div class="card">
                <form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <p class="form-group">
                            <label for="nip">NIP:</label>
                            <input type="text" name="nip" id="nip" value="{{ old('nip') }}" required>
                        </p>

                        <p class="form-group">
                            <label for="nik">NIK:</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}">
                        </p>

                        <p class="form-group">
                            <label for="nama_lengkap">Nama Lengkap:</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                        </p>

                        <p class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir:</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                        </p>

                        <p class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="jenis_kelamin">
                                <option value="">Pilih</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </p>

                        <p class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}">
                        </p>

                        <p class="form-group">
                            <label for="nomor_telepon">Nomor Telepon:</label>
                            <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}">
                        </p>

                        <p class="form-group">
                            <label for="jabatan">Jabatan:</label>
                            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}">
                        </p>

                        <p class="form-group">
                            <label for="pangkat_golongan">Pangkat dan Golongan:</label>
                            <input type="text" name="pangkat_golongan" id="pangkat_golongan" value="{{ old('pangkat_golongan') }}">
                        </p>

                        <p class="form-group">
                            <label for="unit_kerja_id">Unit Kerja:</label>
                            <select name="unit_kerja_id" id="unit_kerja_id">
                                <option value="">Pilih Unit Kerja</option>
                                @foreach ($unit_kerja as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_kerja_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </p>

                        <p class="form-group">
                            <label for="status_pegawai">Status Pegawai:</label>
                            <select name="status_pegawai" id="status_pegawai">
                                <option value="">Pilih</option>
                                <option value="Aktif" {{ old('status_pegawai') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-aktif" {{ old('status_pegawai') == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                                <option value="Pensiun" {{ old('status_pegawai') == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                            </select>
                        </p>

                        <p class="form-group">
                            <label for="foto_profil">Foto Profil:</label>
                            <input type="file" name="foto_profil" id="foto_profil">
                        </p>
                    </div>

                    {{-- Alamat dan tombol tetap satu kolom --}}
                    <p>
                        <label for="alamat">Alamat:</label>
                        <textarea name="alamat" id="alamat">{{ old('alamat') }}</textarea>
                    </p>

                    <p>
                        <button type="submit">Simpan Pegawai</button>
                        <a href="{{ route('pegawai.index') }}" class="btn-custom">Batal</a>
                    </p>
                </form>
            </div>
        </div>
        <footer class="text-center mt-5 mb-3 text-muted" style="font-size: 14px;">
    © 2025 Sistem Informasi Kepegawaian - Dikelola oleh Bagian Kepegawaian
</footer>
    </div>
</body>
</html>
