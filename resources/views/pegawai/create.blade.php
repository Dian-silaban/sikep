@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')

    <style>
        /* Container form */
.container-detail {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    max-width: 700px;
    margin: 0 auto 30px;
}

/* Judul */
.container-detail h2,
h2 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 25px;
    color: #1f2937;
    text-align: center;
}

/* Label dan input */
form label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #374151;
}

form input[type="text"],
form input[type="email"],
form input[type="date"],
form select,
form textarea,
form input[type="file"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 14px;
    margin-bottom: 15px;
    background-color: #fff;
}

/* Tombol Submit dan Batal */
form button[type="submit"],
form a.btn-custom {
    padding: 10px 16px;
    background-color: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

form a.btn-custom {
    background-color: #6b7280;
    margin-left: 10px;
}

form button[type="submit"]:hover {
    background-color: #1e40af;
}

form a.btn-custom:hover {
    background-color: #4b5563;
}

/* Responsif */
@media (max-width: 768px) {
    .container-detail {
        padding: 20px;
    }

    form input,
    form select,
    form textarea {
        font-size: 13px;
    }

    form button,
    form a.btn-custom {
        font-size: 13px;
        padding: 8px 14px;
    }
}

    </style>
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
