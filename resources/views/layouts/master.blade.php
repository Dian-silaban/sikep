<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIKEP Instansi')</title>
</head>
<body>
  
<nav style="background-color: #f8f8f8; padding: 10px 20px; border-bottom: 1px solid #eee;">
    <h1 style="display: inline-block; margin: 0; font-size: 24px;"><a href="{{ url('/') }}" style="text-decoration: none; color: #333;">SIKEP Instansi</a></h1>
    <ul style="list-style: none; margin: 0; padding: 0; display: inline-block; float: right;">
        <li style="display: inline-block; margin-left: 20px;"><a href="{{ route('pegawai.index') }}" style="text-decoration: none; color: #007bff;">Manajemen Pegawai</a></li>
        @auth 
            <li style="display: inline-block; margin-left: 20px;">
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 0; font-size: 16px;">Logout</button>
                </form>
            </li>
        @endauth
        @guest 
            <li style="display: inline-block; margin-left: 20px;"><a href="{{ route('login') }}" style="text-decoration: none; color: #28a745;">Login</a></li>
        @endguest
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