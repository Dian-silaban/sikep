<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        @media (max-width: 768px) {
            .grid-kotak {
                grid-template-columns: 1fr;
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
            .table-dokumen td:nth-of-type(6):before { content: "Tgl. Unggah"; }
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
                        <p>Tidak ada foto profil.</p>
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
                        <strong>TMT</strong>
                        {{ $pegawai->tmt ? \Carbon\Carbon::parse($pegawai->tmt)->format('d-m-Y') : '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>Jenis Kelamin</strong>
                        {{ $pegawai->jenis_kelamin ?? '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>Alamat</strong>
                        {{ $pegawai->alamat ?? '-' }}
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
                        <strong>Jabatan</strong>
                        {{ $pegawai->jabatan ?? '-' }}
                    </div>
                    
                    <div class="item-kotak">
                        <strong>Golongan</strong>
                        {{ $pegawai->golongan->nama_golongan ?? '-' }}
                    </div>

                    <div class="item-kotak">
                        <strong>Eselon</strong>
                        {{ $pegawai->eselon->nama_eselon ?? '-' }}
                    </div>

                    <div class="item-kotak">
                        <strong>Pendidikan</strong>
                        {{ $pegawai->pendidikan->nama_pendidikan ?? '-' }}
                    </div>

                    <div class="item-kotak">
                        <strong>Unit Kerja</strong>
                        {{ $pegawai->unit_kerja->nama_unit ?? '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>Status Pegawai</strong>
                        {{ $pegawai->status_pegawai ?? '-' }}
                    </div>
                    <div class="item-kotak">
                        <strong>TMT Status</strong>
                        {{ $pegawai->tmt_status ? \Carbon\Carbon::parse($pegawai->tmt_status)->format('d-m-Y') : '-' }}
                    </div>
                </div>

                <div class="mt-8 flex justify-center">
                    <a href="{{ route('pegawai.edit', ['pegawai' => $pegawai->id, '_redirect_to' => request()->fullUrl()]) }}" class="btn-custom-edit">Edit Data Pegawai</a>
                    <a href="{{ route('pegawai.index') }}" class="btn-custom-edit">Kembali ke Daftar Pegawai</a>
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

                <table class="table-dokumen">
                    <thead>
                        <tr>
                            <th>Jenis Dokumen</th>
                            <th>Nama File Asli</th>
                            <th>Versi</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Tgl. Unggah</th>
                            <th>TMT Dokumen</th> {{-- BARU: Kolom TMT Dokumen --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($all_dokumen as $doc)
                            <tr style="{{ $doc->status_dokumen == 'Revisi' ? 'background-color: #f0f0f0;' : '' }}">
                                <td>{{ $doc->jenis_dokumen->nama_jenis ?? '-' }}</td>
                                <td>{{ $doc->nama_file_asli }}</td>
                                <td>V{{ $doc->versi_dokumen }}</td>
                                <td>{{ $doc->keterangan ?? '-' }}</td>
                                <td>
                                    <strong>{{ $doc->status_dokumen }}</strong>
                                </td>
                                <td>{{ $doc->tanggal_upload->format('d-m-Y H:i') }}</td>
                                <td>{{ $doc->tmt_dokumen ? \Carbon\Carbon::parse($doc->tmt_dokumen)->format('d-m-Y') : '-' }}</td> {{-- BARU: Tampilkan TMT Dokumen --}}
                                <td class="action-buttons">
                                    {{-- Tombol Lihat --}}
                                    <a href="{{ asset($doc->path_file) }}" target="_blank" class="btn-aksi btn-lihat" title="Lihat Dokumen">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
                                    </a>

                                    {{-- Tombol Unduh --}}
                                    <a href="{{ route('dokumen.download', $doc->id) }}" target="_blank" class="btn-aksi btn-unduh" title="Unduh Dokumen">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.6a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5V10.4a.5.5 0 0 1 1 0v2.6a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13V10.4a.5.5 0 0 1 .5-.5z"/>
                                            <path d="M7.646 10.854a.5.5 0 0 0 .708 0L11 8.207V1.5a.5.5 0 0 0-1 0v6.793L8.354 5.146a.5.5 0 1 0-.708.708L10.293 9H6.707l2.647-2.646a.5.5 0 0 0-.708-.708L5 9.793 7.646 10.854z"/>
                                        </svg>
                                    </a>

                                    {{-- Tombol Rename --}}
                                    <a href="{{ route('dokumen.edit', $doc->id) }}" class="btn-aksi btn-rename" title="Rename Dokumen">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 1 .707 0l2.293 2.293a.5.5 0 0 1 0 .707l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5zM11.207 2.5 13.5 4.793 12.5 5.793 10.207 3.5 11.207 2.5zm1.586 3L10.5 3.207l-8.646 8.647-.854 2.146 2.146-.854L12.793 5.5z"/>
                                        </svg>
                                    </a>

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
                                <td colspan="8">Tidak ada dokumen aktif atau revisi untuk pegawai ini.</td> {{-- Perbarui colspan --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
            </div>
            
        </div>
        <footer class="text-center mt-5 mb-3 text-muted" style="font-size: 14px;">
    © 2025 Sistem Informasi Kepegawaian - Dikelola oleh Bagian Kepegawaian
</footer>
        
    </div>
    
</body>
</html>
