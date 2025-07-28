{{-- resources/views/layouts/settings.blade.php --}}
@extends('layouts.app') {{-- Menggunakan layout utama aplikasi Anda --}}

@section('content')
<div class="row">
    <div class="col-md-3">
        {{-- Sidebar navigasi --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Pengaturan</h5>
            </div>
            <div class="list-group list-group-flush">
                {{-- Salin Dokumen --}}
                {{-- Class 'active' berdasarkan route yang sedang aktif --}}
                <a href="{{ route('settings.document_migration.index') }}"
                   class="list-group-item list-group-item-action {{ request()->routeIs('settings.document_migration.index') ? 'active' : '' }}">
                    <i class="bi bi-files me-2"></i>Salin Dokumen
                </a>

                {{-- Manajemen Unit Kerja --}}
                <a href="{{ route('settings.unit-kerja.index') }}"
                   class="list-group-item list-group-item-action {{ request()->routeIs('settings.unit-kerja.index') ? 'active' : '' }}">
                    <i class="bi bi-building me-2"></i>Manajemen Unit Kerja
                </a>

                {{-- Manajemen Jenis Dokumen --}}
                <a href="{{ route('settings.jenis-dokumen.index') }}"
                   class="list-group-item list-group-item-action {{ request()->routeIs('settings.jenis-dokumen.index') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text me-2"></i>Manajemen Dokumen
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        {{-- Konten spesifik halaman pengaturan akan diinject di sini --}}
        @yield('setting_content')
    </div>
</div>
@endsection