<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Pengaturan</h5>
    </div>
    <div class="list-group list-group-flush">
        {{-- Salin Dokumen --}}
        <a href="{{ route('settings.document_migration.index') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('settings.document_migration.*') ? 'active' : '' }}">
            <i class="bi bi-files me-2"></i>Salin Dokumen
        </a>

        {{-- Manajemen Unit Kerja --}}
        <a href="{{ route('settings.unit-kerja.index') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('settings.unit-kerja.*') ? 'active' : '' }}">
            <i class="bi bi-building me-2"></i>Manajemen Unit Kerja
        </a>

        {{-- Manajemen Jenis Dokumen --}}
        <a href="{{ route('settings.jenis-dokumen.index') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('settings.jenis-dokumen.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text me-2"></i>Manajemen Dokumen
        </a>

        <a href="{{ route('settings.bezetting.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('settings.bezetting.index') || request()->routeIs('settings.bezetting.export_excel') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill me-2"></i>Laporan Bezetting
        </a>
        {{-- Link untuk Manajemen Data Bezetting Kontrak --}}
        <a href="{{ route('settings.bezetting_kontrak.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('settings.bezetting_kontrak.*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill me-2"></i>Data Kontrak (Bezetting)
        </a>

        {{-- Tambahkan menu pengaturan lainnya di sini --}}
    </div>
</div>
