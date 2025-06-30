@extends('layouts.master')

@section('title', 'Edit Pegawai')

@section('content')
    <h2>Edit Data Pegawai: {{ $pegawai->nama_lengkap }}</h2>

    <form method="POST" action="{{ route('pegawai.update', $pegawai->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="_redirect_to" value="{{ URL::previous() }}">

        <p>
            <label for="nip">NIP:</label><br>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $pegawai->nip) }}" required>
        </p>
        <p>
            <label for="nama_lengkap">Nama Lengkap:</label><br>
            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" required>
        </p>
        <p>
            <label for="tanggal_lahir">Tanggal Lahir:</label><br>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('Y-m-d') : '') }}">
        </p>
        <p>
            <label for="jenis_kelamin">Jenis Kelamin:</label><br>
            <select name="jenis_kelamin" id="jenis_kelamin">
                <option value="">Pilih</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </p>
        <p>
            <label for="alamat">Alamat:</label><br>
            <textarea name="alamat" id="alamat">{{ old('alamat', $pegawai->alamat) }}</textarea>
        </p>
        <p>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" value="{{ old('email', $pegawai->email) }}">
        </p>
        <p>
            <label for="nomor_telepon">Nomor Telepon:</label><br>
            <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $pegawai->nomor_telepon) }}">
        </p>
        <p>
            <label for="jabatan">Jabatan:</label><br>
            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}">
        </p>
        <p>
            <label for="unit_kerja_id">Unit Kerja:</label><br>
            <select name="unit_kerja_id" id="unit_kerja_id">
                <option value="">Pilih Unit Kerja</option>
                @foreach ($unit_kerja as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_kerja_id', $pegawai->unit_kerja_id) == $unit->id ? 'selected' : '' }}>
                        {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>
        </p>
        <p>
            <label for="status_pegawai">Status Pegawai:</label><br>
            <select name="status_pegawai" id="status_pegawai">
                <option value="">Pilih</option>
                <option value="Aktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Non-aktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                <option value="Pensiun" {{ old('status_pegawai', $pegawai->status_pegawai) == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
            </select>
        </p>
        <p>
            <label for="tanggal_bergabung">Tanggal Bergabung:</label><br>
            <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" value="{{ old('tanggal_bergabung', $pegawai->tanggal_bergabung ? \Carbon\Carbon::parse($pegawai->tanggal_bergabung)->format('Y-m-d') : '') }}">
        </p>
        <p>
            <label for="foto_profil">Foto Profil:</label><br>
            @if ($pegawai->foto_profil_path)
                <img src="{{ asset($pegawai->foto_profil_path) }}" alt="Foto Profil Saat Ini" style="width: 50px; height: 50px; object-fit: cover;"><br>
                <input type="checkbox" name="hapus_foto_profil" value="1" id="hapus_foto_profil">
                <label for="hapus_foto_profil">Hapus Foto Profil Saat Ini</label><br>
            @endif
            <input type="file" name="foto_profil" id="foto_profil">
            <small>Kosongkan jika tidak ingin mengubah.</small>
        </p>
        <p>
            <button type="submit">Perbarui Pegawai</button>
            <a href="{{ URL::previous() }}">Batal</a>
        </p>
    </form>
@endsection