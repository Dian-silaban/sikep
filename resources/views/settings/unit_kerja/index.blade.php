@extends('layouts.app') {{-- Menggunakan layout utama Anda --}}

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar') {{-- Sidebar pengaturan --}}
    </div>
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manajemen Unit Kerja</h5>
                <a href="{{ route('settings.unit-kerja.create') }}" class="btn btn-primary btn-sm">Tambah Unit Kerja</a>
            </div>
            <div class="card-body">
                @if ($unitKerjas->isEmpty())
                    <p class="text-center">Belum ada unit kerja yang ditambahkan.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Unit</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unitKerjas as $index => $unitKerja)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $unitKerja->nama_unit }}</td>
                                    <td>{{ $unitKerja->deskripsi ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('settings.unit-kerja.edit', $unitKerja->id) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('settings.unit-kerja.destroy', $unitKerja->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit kerja ini? Pastikan tidak ada pegawai yang terhubung dengan unit ini.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection