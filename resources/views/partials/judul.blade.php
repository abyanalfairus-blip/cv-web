{{-- Layar judul --}}
<header class="title">
    @if ($profil->pre_judul)
        <div class="pre">{{ $profil->pre_judul }}</div>
    @endif

    <h1>{{ $profil->nama_judul_1 }}@if ($profil->nama_judul_2)<br>{{ $profil->nama_judul_2 }}@endif</h1>
    <p class="sub">{{ $profil->subjudul }}</p>

    <div class="social">
        @foreach ($profil->kontak as $k)
            <a href="{{ $k->url }}" @if ($k->eksternal) target="_blank" rel="noopener" @endif>{{ $k->label }}</a>
        @endforeach
    </div>

    <div class="title-actions">
        <a class="start" href="#status"><span class="blink">▶ PRESS START</span></a>
        <a class="start dl" href="{{ route('cv.download') }}">⬇ DOWNLOAD CV</a>
    </div>
</header>
