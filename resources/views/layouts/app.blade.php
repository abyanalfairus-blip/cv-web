<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    {{-- Pratinjau saat link dibagikan (WhatsApp, LinkedIn, dll.) --}}
    <meta property="og:type" content="profile">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:url" content="{{ url('/') }}">
    <meta name="theme-color" content="#13112b">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&family=Pixelify+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/cv.css') }}?v={{ filemtime(public_path('css/cv.css')) }}">
</head>
<body>
    <canvas id="stars" aria-hidden="true"></canvas>

    <div class="page">
        @yield('content')
    </div>

    <script src="{{ asset('js/cv.js') }}?v={{ filemtime(public_path('js/cv.js')) }}"></script>
</body>
</html>
