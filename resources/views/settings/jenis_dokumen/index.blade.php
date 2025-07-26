@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('settings.sidebar')
    </div>
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manajemen Jenis Dokumen</h5>
                <a href="{{ route('settings.jenis-dokumen.create') }}" class="btn btn-primary btn-sm">Tambah Jenis Dokumen</a>
            </div>
            <div class="card-body">
                @if ($jenisDokumens->isEmpty())
                    <p class="text-center">Belum ada jenis dokumen yang ditambahkan.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Jenis</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenisDokumens as $index => $jenisDokuman)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $jenisDokuman->nama_jenis }}</td>
                                    <td>{{ $jenisDokuman->deskripsi ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('settings.jenis-dokumen.edit', $jenisDokuman->id) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('settings.jenis-dokumen.destroy', $jenisDokuman->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis dokumen ini? Pastikan tidak ada dokumen pegawai yang terhubung dengan jenis ini.');">
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
