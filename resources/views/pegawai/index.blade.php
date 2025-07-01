@extends('layouts.app')

@section('title', 'Daftar Pegawai')


@section('content')

<style>
    .tabel-daftar {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    background-color: #fff;
    border: 1px solid #878b91;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.tabel-daftar thead {
    background-color: #363d53; /* warna header */
}


.tabel-daftar th,
.tabel-daftar td {
    border: 1px solid #e2e8f0;
    padding: 12px 16px; /* lebih kecil dari sebelumnya */
    text-align: center; /* isi tabel ke tengah */
    vertical-align: middle;
}

.tabel-daftar th {
    font-weight: bold;
    color: #fff;
    
}

.tabel-daftar tbody tr:hover {
    background-color: #f9fafb;
}

.tabel-daftar img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.tabel-daftar a {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 500;
}


.tabel-daftar button {
    background: none;
    border: none;
    color: #dc2626;
    cursor: pointer;
    font-size: 14px;
}

.btn-tambah {
    display: inline-block;
    padding: 8px 16px;
    background-color: #363d53;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
}

.btn-tambah:hover {
    background-color: #292e3f;
}

.form-pencarian {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.form-pencarian input[type="text"] {
    padding: 6px 10px;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    width: 700px;
    height: 45px;
    font-size: 16px;
}

.form-pencarian button {
    padding: 6px 12px;
    background-color: #10b981;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    height: 44px;
    width: 70px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
}

.form-pencarian button:hover {
    background-color: #059669;
}

.form-pencarian a {
    color: #ef4444;
    font-size: 14px;
    text-decoration: none;
}

.form-pencarian a:hover {
    text-decoration: underline;
}

.action-buttons {

    justify-content: center;
    gap: 6px;
    white-space: nowrap;
    align-items: center;
}

.action-buttons form {
    display: inline-block;
    margin: 0;
}


.btn-aksi {
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 6px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: 0.2s ease-in-out;
    color: #fff !important;
}

.btn-lihat {
    background-color: #3b82f6; /* biru */
    color: white;
}

.btn-lihat:hover {
    background-color: #2563eb;
}

.btn-edit {
    background-color: #10b981; /* kuning */
    color: white;
}

.btn-edit:hover {
    background-color: #0e9266;
}

.btn-hapus {
    background-color: #ef4444 !important;/* merah */
    color: white;
    
}

.btn-hapus:hover {
    background-color: #b41f1f !important;
}

.header-pegawai {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-pegawai h2 {
    font-size: 30px;
    font-weight: 600;
    margin: 0;
}


</style>
    <div class="header-pegawai">
        <h2>Daftar Pegawai</h2>
        <p><a href="{{ route('pegawai.create') }}" class="btn-tambah"> + Tambah Pegawai Baru</a></p>
    </div>

    {{-- Form Pencarian --}}
    <form class="form-pencarian" method="GET" action="{{ route('pegawai.index') }}" >
        <input type="text" name="search" placeholder="Cari NIP, Nama, Jabatan, Unit Kerja..." value="{{ $searchTerm ?? '' }}" >
        <button type="submit">Cari</button>
        @if ($searchTerm ?? '')
            <a href="{{ route('pegawai.index') }}" >Reset Pencarian</a>
        @endif
    </form>

    <table class="tabel-daftar" border="1" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Foto Profil</th>  
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Unit Kerja</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pegawai as $p)
                <tr>
                    <td>
                     
                        @if ($p->foto_profil_path)
                            <img src="{{ asset($p->foto_profil_path) }}" alt="Foto Profil {{ $p->nama_lengkap }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                        @else 
                            <img src="{{ asset('images/default_profile.png') }}" alt="Foto Profil Default" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            
                        @endif
                    </td>
                   
                    <td>{{ $p->nip }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->jabatan ?? '-' }}</td>
                    <td>{{ $p->unit_kerja->nama_unit ?? '-' }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('pegawai.show', $p->id) }}" class="btn-aksi btn-lihat">Lihat</a>
                        <a href="{{ route('pegawai.edit', $p->id) }}" class="btn-aksi btn-edit">Edit</a>
                        <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-aksi btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus pegawai {{ $p->nama_lengkap }}?');">
                            Hapus
                        </button>
                    </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data pegawai.</td> 
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $pegawai->links() }}
    </div>



@endsection


