<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIKEP Instansi') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<style>
    
    * {
        font-family: 'Poppins';
    }
    .navbar-brand{
        color: #363d53;
    }

    .navbar{
        background-color: #fff;
    }
    
    .btn-back {
    background-color: #363d53 !important;
    color: #fff !important;
    border-radius: 10px;
    transition: background-color 0.3s;
    padding: 10px;
}

.btn-back:hover {
    background-color: #2b2f3d;
    color: #fff !important;
}

span{
    padding: 10px;
}

</style>
<body class="bg-light">

    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg shadow-sm mb-5" style="display: flex">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}"> <img src="{{ asset('img/logo.png') }}" alt="Logo" width="60" height="60" class="d-inline-block align-text-top">
                <span>SIKEP BPKAD Kota Metro</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn-back btn-sm" href="{{ route('pegawai.index') }}">Logout</a>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
        crossorigin="anonymous">
    </script>

    
    

<footer class="text-center mt-5 mb-3 text-muted" style="font-size: 14px;">
    © 2025 Sistem Informasi Kepegawaian - Dikelola oleh Bagian Kepegawaian
</footer>

@yield('scripts')
</body>
</html>
