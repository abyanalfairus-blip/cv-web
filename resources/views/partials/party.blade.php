{{-- 07 · Kontak (tabel: kontak, profil) --}}
<section id="party" aria-labelledby="h-party">
    <div class="sec-h"><span class="stage">07</span><h2 id="h-party">AJAK MASUK PARTY</h2></div>

    <div class="px party">
        <div>
            @if ($profil->ajakan)
                <p class="party-lead">{{ $profil->ajakan }}</p>
            @endif
            <div class="links">
                @foreach ($profil->kontak as $k)
                    <a class="lk" href="{{ $k->url }}" @if ($k->eksternal) target="_blank" rel="noopener" @endif>
                        <span class="li">{{ $k->ikon }}</span>
                        <span><b>{{ $k->label }}</b><em>{{ $k->teks }}</em></span>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="party-actions">
            <a class="btn btn-dl" href="{{ route('cv.download') }}">⬇ DOWNLOAD CV PDF</a>
            <a class="dl-preview" href="{{ route('cv.download', ['lihat' => 1]) }}" target="_blank" rel="noopener">Lihat dulu di browser</a>
            <button class="btn" id="copy" type="button" data-email="{{ $profil->email }}">SALIN EMAIL</button>
        </div>
    </div>
</section>
