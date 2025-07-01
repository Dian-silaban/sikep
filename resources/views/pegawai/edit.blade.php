@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')


<div class="form-container">
    <h2>Edit Data Pegawai: {{ $pegawai->nama_lengkap }}</h2>

    <form method="POST" action="{{ route('pegawai.update', $pegawai->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="nip">NIP:</label>
        <input type="text" name="nip" id="nip" value="{{ old('nip', $pegawai->nip) }}" required>

        <label for="nama_lengkap">Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('Y-m-d') : '') }}">

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select name="jenis_kelamin" id="jenis_kelamin">
            <option value="">Pilih</option>
            <option value="Laki-laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" id="alamat">{{ old('alamat', $pegawai->alamat) }}</textarea>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email', $pegawai->email) }}">

        <label for="nomor_telepon">Nomor Telepon:</label>
        <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $pegawai->nomor_telepon) }}">

        <label for="jabatan">Jabatan:</label>
        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}">

        <label for="unit_kerja_id">Unit Kerja:</label>
        <select name="unit_kerja_id" id="unit_kerja_id">
            <option value="">Pilih Unit Kerja</option>
            @foreach ($unit_kerja as $unit)
                <option value="{{ $unit->id }}" {{ old('unit_kerja_id', $pegawai->unit_kerja_id) == $unit->id ? 'selected' : '' }}>
                    {{ $unit->nama_unit }}
                </option>
            @endforeach
        </select>

        <label for="status_pegawai">Status Pegawai:</label>
        <select name="status_pegawai" id="status_pegawai">
            <option value="">Pilih</option>
            <option value="Aktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Non-aktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
            <option value="Pensiun" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
        </select>

        <label for="tanggal_bergabung">Tanggal Bergabung:</label>
        <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" value="{{ old('tanggal_bergabung', $pegawai->tanggal_bergabung ? \Carbon\Carbon::parse($pegawai->tanggal_bergabung)->format('Y-m-d') : '') }}">

        <label for="foto_profil">Foto Profil:</label>
        @if ($pegawai->foto_profil_path)
            <img src="{{ asset($pegawai->foto_profil_path) }}" alt="Foto Profil Saat Ini" class="foto-preview"><br>
            <input type="checkbox" name="hapus_foto_profil" value="1" id="hapus_foto_profil">
            <label for="hapus_foto_profil">Hapus Foto Profil Saat Ini</label>
        @endif
        <input type="file" name="foto_profil" id="foto_profil">
        <small>Kosongkan jika tidak ingin mengubah.</small>

        <div class="form-actions">
            <button type="submit">Perbarui Pegawai</button>
            <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn-batal">Batal</a>
        </div>
    </form>
</div>
@endsection
