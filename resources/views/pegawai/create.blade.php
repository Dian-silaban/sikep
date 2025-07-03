@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')


    {{-- <h2>Tambah Pegawai Baru</h2> --}}

    <div class="container-detail">
        <h2>Tambah Pegawai Baru</h2>
        <form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
            @csrf
            <p>
                <label for="nip">NIP:</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip') }}" required>
            </p>

            <p>
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
            </p>

            <p>
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
            </p>

            <p>
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select name="jenis_kelamin" id="jenis_kelamin">
                    <option value="">Pilih</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </p>

            <p>
                <label for="alamat">Alamat:</label>
                <textarea name="alamat" id="alamat">{{ old('alamat') }}</textarea>
            </p>

            <p>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
            </p>

            <p>
                <label for="nomor_telepon">Nomor Telepon:</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}">
            </p>

            <p>
                <label for="jabatan">Jabatan:</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}">
            </p>

            <p>
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

            <p>
                <label for="status_pegawai">Status Pegawai:</label>
                <select name="status_pegawai" id="status_pegawai">
                    <option value="">Pilih</option>
                    <option value="Aktif" {{ old('status_pegawai') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-aktif" {{ old('status_pegawai') == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                    <option value="Pensiun" {{ old('status_pegawai') == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                </select>
            </p>

            <p>
                <label for="tanggal_bergabung">Tanggal Bergabung:</label>
                <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" value="{{ old('tanggal_bergabung') }}">
            </p>

            <p>
                <label for="foto_profil">Foto Profil:</label>
                <input type="file" name="foto_profil" id="foto_profil">
            </p>

            <p>
                <button type="submit">Simpan Pegawai</button>
                <a href="{{ route('pegawai.index') }}" class="btn-custom">Batal</a>
            </p>
        </form>
    </div>
@endsection
