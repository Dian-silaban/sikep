[media pointer="file-service://file-3nhNGt4UAZvEei7E4gr17J"]
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    {{-- Jika Anda tidak menggunakan Vite untuk file ini, Anda bisa menghapus baris di atas.
         Jika Anda tetap menggunakannya, pastikan app.css tidak menimpa gaya di sini. --}}

    <!-- Custom Styles for Animated Gradient Background and Login Form -->
    <style>
        /* Reset CSS dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f2f5; /* Warna latar belakang fallback */
            overflow: hidden; /* Penting untuk animasi latar belakang */
            position: relative;
        }

        /* Container untuk animasi latar belakang (Gradien Bergerak) */
        .animated-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #4CAF50, #2196F3, #9C27B0, #FF5722); /* Gradien warna */
            background-size: 400% 400%; /* Ukuran besar untuk memungkinkan pergerakan */
            animation: gradientAnimation 15s ease infinite; /* Animasi gradien */
            z-index: 0; /* Pastikan di belakang form */
            filter: blur(80px); /* Efek blur agar terlihat seperti cairan/gelombang */
        }

        /* Keyframes untuk animasi gradien */
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Form Login Container (Transparan di atas background animasi) */
        .login-container {
            background-color: rgba(255, 255, 255, 0.15); /* Transparan agar gradien terlihat */
            backdrop-filter: blur(10px); /* Efek blur pada background card */
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            border-radius: 20px; /* Lebih rounded */
            padding: 40px; /* Padding disesuaikan */
            width: 100%;
            max-width: 400px; /* Max width agar tidak terlalu lebar */
            text-align: center;
            z-index: 1; /* Pastikan di atas latar belakang */
            position: relative; /* Untuk z-index bekerja */
            color: #fff; /* Warna teks default untuk konten di dalam card */
        }

        /* Styling untuk logo di dalam login card */
        .login-logo-container {
            margin-bottom: 25px;
            display: flex;
            justify-content: center;
        }

        .login-logo-container img {
            max-width: 100px; /* Ukuran logo BPKAD Metro */
            height: auto;
            border-radius: 8px; /* Sedikit rounded untuk logo */
        }

        .login-container h2 {
            font-size: 1.8rem;
            color: #fff; /* Warna teks judul */
            margin-bottom: 10px;
        }

        .login-container p {
            font-size: 0.95rem;
            color: #e0e0e0; /* Warna teks paragraf */
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #e0e0e0; /* Warna teks label lebih terang agar terbaca */
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid rgba(255, 255, 255, 0.3); /* Border transparan */
            border-radius: 10px;
            font-size: 1rem;
            color: #333; /* Text color untuk input */
            background-color: rgba(255, 255, 255, 0.8); /* Background putih semi-transparan */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-group input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .options-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        .remember-me-container { /* Menggunakan nama kelas yang konsisten */
            display: flex;
            align-items: center;
            color: #e0e0e0; /* Warna teks "Ingat Saya" lebih terang */
        }

        .remember-me-container input[type="checkbox"] {
            margin-right: 8px;
            accent-color: #007bff; /* Warna checkbox */
        }

        .forgot-password-link { /* Menggunakan nama kelas yang konsisten */
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password-link:hover {
            color: #49566a; /* Warna hover lebih terang */
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            background-color: #374151;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        .login-button:hover {
            background-color: #374151;
            transform: translateY(-2px);
        }

        .divider {
            margin: 30px 0;
            color: #aaa;
            position: relative;
            font-size: 0.9em;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.2); /* Warna garis lebih transparan */
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .social-login {
            margin-bottom: 30px;
        }

        .social-login button {
            width: 100%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.1); /* Background transparan */
            color: #fff; /* Warna teks putih */
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .social-login button:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .social-login button img {
            width: 20px;
            height: 20px;
        }

        .signup-link {
            font-size: 0.95rem;
            color: #e0e0e0; /* Warna teks putih */
            margin-top: 20px;
        }

        .signup-link a {
            color: #374151;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #66b3ff;
        }

        /* Responsif */
        @media (max-width: 500px) {
            .login-container {
                margin: 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <!-- Latar Belakang Gradien Bergerak -->
    <div class="animated-background"></div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        

        <!-- Login Card Container -->
        <div class="w-full sm:max-w-md px-6 py-4 login-container">
            <div class="login-logo-container">
            <a href="/">
                <img src="{{ asset('img/LOGO_KOTA_METRO.png') }}" alt="Logo SIKAP">
            </a>
        </div>
            <h2>Selamat Datang Kembali!</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <label for="email">Username</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Username Anda" required autofocus autocomplete="username">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required autocomplete="current-password">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="options-group">
                    <div class="remember-me-container">
                        <input type="checkbox" id="remember_me" name="remember">
                        <label for="remember_me">Ingat Saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="forgot-password-link" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="login-button">Masuk</button>
            </form>

        
        </div>
    </div>
</body>
</html>
