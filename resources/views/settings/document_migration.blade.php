@extends('layouts.app') {{-- Atau layouts.app jika itu layout utama Anda --}}

@section('title', 'Migrasi Dokumen Massal')

@section('content')
    <div class="form-container">
        <h2 class="form-header">Salin Semua Dokumen ke Lokasi Lain</h2>

        <form method="POST" action="{{ route('settings.document_migration.start') }}">
            @csrf
            <div class="mb-3">
                <label for="destination_path" class="form-label">Folder Tujuan Penyalinan (Path Lengkap):</label>
                <input type="text" name="destination_path" id="destination_path" class="form-control"
                       value="{{ old('destination_path', $lastBackupPath) }}"
                       placeholder="Contoh: D:\BackupSIKEP atau \\KomputerServer\SharedBackup">
                <div class="form-text">
                    Masukkan path lengkap folder tempat semua dokumen akan disalin.
                    Pastikan aplikasi memiliki izin tulis ke folder ini.
                    Untuk folder di jaringan (LAN), gunakan format `\\NamaKomputer\NamaShare` atau `\\IP_Address\NamaShare`.
                </div>
                @error('destination_path')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Mulai Penyalinan Semua Dokumen</button>
        </form>

        <div class="mt-4 alert alert-info">
            <p><strong>Penting:</strong></p>
            <ul>
                <li>Proses penyalinan akan berjalan di latar belakang. Anda dapat menutup halaman ini.</li>
                <li>Pastikan "Queue Worker" Laravel sedang berjalan di server Anda agar proses ini dapat dieksekusi.</li>
                <li>File yang sudah ada di folder tujuan dengan nama yang sama akan ditimpa.</li>
            </ul>
        </div>
    </div>
@endsection