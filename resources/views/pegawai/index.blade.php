@extends('layouts.master')

@section('title', 'Daftar Pegawai')

@section('content')
    <h2>Daftar Pegawai</h2>
    <p><a href="{{ route('pegawai.create') }}">Tambah Pegawai Baru</a></p>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('pegawai.index') }}" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Cari NIP, Nama, Jabatan, Unit Kerja..." value="{{ $searchTerm ?? '' }}" style="width: 300px; padding: 5px;">
        <button type="submit">Cari</button>
        @if ($searchTerm ?? '')
            <a href="{{ route('pegawai.index') }}" style="margin-left: 10px;">Reset Pencarian</a>
        @endif
    </form>

    <table border="1" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Foto Profil</th> {{-- KOLOM BARU UNTUK FOTO --}}
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
                        {{-- KODE BARU UNTUK MENAMPILKAN FOTO --}}
                        @if ($p->foto_profil_path)
                            <img src="{{ asset($p->foto_profil_path) }}" alt="Foto Profil {{ $p->nama_lengkap }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                        @else
                            {{-- Placeholder jika tidak ada foto profil --}}
                            <img src="{{ asset('images/default_profile.png') }}" alt="Foto Profil Default" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            {{-- Anda perlu membuat folder public/images/ dan menaruh default_profile.png di sana --}}
                        @endif
                    </td>
                    {{-- AKHIR KODE BARU --}}
                    <td>{{ $p->nip }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->jabatan ?? '-' }}</td>
                    <td>{{ $p->unit_kerja->nama_unit ?? '-' }}</td>
                    <td>
                        <a href="{{ route('pegawai.show', $p->id) }}">Lihat</a> |
                        <a href="{{ route('pegawai.edit', $p->id) }}">Edit</a> |
                        <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus?');">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data pegawai.</td> {{-- Kolom span bertambah jadi 6 --}}
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $pegawai->links() }}
    </div>
@endsection