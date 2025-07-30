<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Kepegawaian</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</head>


<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm mb-5" style="display: flex">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}"> <img src="{{ asset('img/LOGO_KOTA_METRO.png') }}" alt="Logo" width="60" height="60" class="d-inline-block align-text-top">
                <span>SIKEP BPKAD Kota Metro</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse custom-nav" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('reports.*') ? 'active' : '' }}" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Laporan Usulan <span class="custom-badge">4</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="reportsDropdown">
                            <h6 class="dropdown-header">Buku Jaga Pegawai:</h6>
                            <a class="dropdown-item" href="{{ route('reports.usulan-berkala.index') }}">Buku Jaga Usulan KGB</a>
                            <a class="dropdown-item" href="{{ route('reports.usulan-kenaikan-pangkat.index') }}">Daftar Jaga Usulan KP</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Laporan Lain (Opsional)</a>
                        </div>
                    </li>

                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('settings.index') ? 'active' : '' }}" href="{{ route('settings.index') }}">Pengaturan</a>
                    </li>
                    @endauth

                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Keluar
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mb-5">
        {{-- Alert success --}}
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Alert error --}}
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
        <div class="alert alert-warning">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
        crossorigin="anonymous">
    </script>

    <script>
        // Debug Bootstrap Modal
        document.addEventListener('DOMContentLoaded', function() {
            // Test jika Bootstrap tersedia
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap JavaScript tidak ter-load!');
                alert('Bootstrap JavaScript tidak ter-load! Modal tidak akan berfungsi.');
                return;
            }

            // Test modal functionality
            console.log('Bootstrap loaded successfully');

            // Manual trigger untuk debugging
            window.debugModal = function(modalId) {
                const modal = new bootstrap.Modal(document.getElementById(modalId));
                modal.show();
            };
        });
    </script>


    <footer class="text-center mt-5 mb-3 text-muted" style="font-size: 14px;">
        © 2025 Sistem Informasi Kepegawaian - Dikelola oleh Bagian Kepegawaian
    </footer>

    @yield('scripts')

</body>

</html>