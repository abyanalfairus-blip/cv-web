<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Login · Admin CV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="login-body">
    <form class="login" method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div class="brand">CV<span>ADMIN</span></div>
        <p class="login-sub">Masuk untuk mengelola isi CV.</p>

        @if (session('pesan'))
            <div class="flash">{{ session('pesan') }}</div>
        @endif

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">

        @error('email') <p class="err">{{ $message }}</p> @enderror
        @error('password') <p class="err">{{ $message }}</p> @enderror

        <label class="cek"><input type="checkbox" name="ingat" value="1"> Ingat saya</label>

        <button class="tombol" type="submit">Masuk</button>
        <a class="kembali" href="{{ route('cv') }}">← Kembali ke website</a>
    </form>
</body>
</html>
