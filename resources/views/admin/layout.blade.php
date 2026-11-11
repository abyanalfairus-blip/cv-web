<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title') · Admin CV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body>
@php
    // Menu sidebar: route => label
    $menu = [
        'Utama' => [
            'admin.dashboard'  => 'Dashboard',
            'admin.profil.index' => 'Profil',
            'admin.kontak.index' => 'Kontak',
        ],
        'Riwayat' => [
            'admin.pendidikan.index' => 'Pendidikan',
            'admin.pengalaman.index' => 'Pengalaman',
            'admin.sertifikat.index' => 'Sertifikat',
            'admin.pencapaian.index' => 'Pencapaian',
        ],
        'Keahlian' => [
            'admin.kategori-skill.index' => 'Kategori Skill',
            'admin.skill.index'          => 'Skill',
            'admin.peralatan.index'      => 'Tools',
        ],
    ];
@endphp
<div class="shell">
    <aside class="side">
        <a class="brand" href="{{ route('admin.dashboard') }}">CV<span>ADMIN</span></a>
        <nav>
            @foreach ($menu as $grup => $item)
                <div class="nav-grup">{{ $grup }}</div>
                @foreach ($item as $r => $label)
                    @php $aktif = request()->routeIs($r) || (str_ends_with($r, '.index') && request()->routeIs(\Illuminate\Support\Str::beforeLast($r, '.') . '.*')); @endphp
                    <a href="{{ route($r) }}" class="{{ $aktif ? 'on' : '' }}">{{ $label }}</a>
                @endforeach
            @endforeach
        </nav>
        <div class="side-foot">
            <a href="{{ route('cv') }}" target="_blank" rel="noopener">Lihat website ↗</a>
            <a href="{{ route('cv.download', ['lihat' => 1]) }}" target="_blank" rel="noopener">Lihat PDF ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
            <small>{{ auth()->user()->email }}</small>
        </div>
    </aside>

    <main class="isi">
        @if (session('pesan'))
            <div class="flash" role="status">{{ session('pesan') }}</div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
