@extends('layouts.app')

@section('title', 'Migrasi Dokumen Massal')

@section('content')
  <div class="form-container">
    <h2 class="form-header fw-bold mb-4">Salin Semua Dokumen ke Lokasi Lain</h2>


    <form method="POST" action="{{ route('settings.document_migration.start') }}">
      @csrf
      <div class="mb-3">
        <label for="destination_path" class="form-label fw-semibold">
          Lokasi Folder Tujuan (Path Lengkap):
        </label>
        <input
          type="text"
          name="destination_path"
          id="destination_path"
          class="form-control"
          placeholder="Contoh: D:\BackupSIKEP atau \\KomputerServer\SharedBackup"
          value="{{ old('destination_path', $lastBackupPath) }}"
        >
        <div class="form-text">
  Masukkan alamat lengkap folder tempat dokumen akan disalin. <br>
  Pastikan folder tersebut bisa diakses oleh aplikasi ini.
  <ul class="mt-1 mb-0 ps-3">
    <li>Jika folder ada di komputer ini, pastikan folder tidak dikunci atau hanya-baca.</li>
    <li>Jika folder ada di komputer lain (jaringan), pastikan sudah dibagikan (shared) dan memberi izin tulis.</li>
    <li>Contoh format: <code>D:\BackupSIKEP</code> atau <code>\\NamaKomputer\NamaFolder</code>.</li>
  </ul>
</div>

        @error('destination_path')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="d-flex gap-2">

  <button type="submit" class="btn btn-primary">
    Mulai Penyalinan Semua Dokumen
  </button>

  <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Kembali ke Daftar Pegawai</a>
</div>


    </form>



    <div class="mt-4 alert alert-info">
      <p class="fw-bold mb-2">Catatan Penting:</p>
      <ul class="mb-0">
        <li>Proses penyalinan akan berjalan di latar belakang. Anda boleh menutup halaman ini.</li>
        <li>Pastikan sistem pemrosesan otomatis di server aktif (disebut "Queue Worker" di Laravel),
  agar proses penyalinan bisa berjalan meskipun Anda menutup halaman ini.</li>
        <li>Jika ada file dengan nama yang sama di folder tujuan, file tersebut akan diganti (ditimpa).</li>
      </ul>
    </div>
  </div>

@endsection
