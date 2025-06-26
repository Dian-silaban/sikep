<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIKEP Instansi')</title>
</head>
<body>
    <nav>
        <h1><a href="{{ url('/') }}">SIKEP Instansi</a></h1>
        <ul>
            <li><a href="{{ route('pegawai.index') }}">Manajemen Pegawai</a></li>
        </ul>
    </nav>

    <main>
        @if (session('success'))
            <div style="background-color: lightgreen; padding: 10px; margin-bottom: 10px;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background-color: lightcoral; padding: 10px; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: lightsalmon; padding: 10px; margin-bottom: 10px;">
                <strong>Error:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>