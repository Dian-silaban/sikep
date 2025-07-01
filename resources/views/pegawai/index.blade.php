@extends('layouts.app')

@section('title', 'Daftar Pegawai')


@section('content')


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


