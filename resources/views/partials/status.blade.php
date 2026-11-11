{{-- 01 · Status karakter (tabel: profil, pendidikan) --}}
<section id="status" aria-labelledby="h-status">
    <div class="sec-h"><span class="stage">01</span><h2 id="h-status">STATUS KARAKTER</h2></div>

    <div class="px status">
        <div class="avatar-box">
            <canvas id="sprite" width="14" height="17" aria-label="Avatar pixel {{ $profil->nama }}"></canvas>
            <div class="cls">PLAYER 1</div>
        </div>

        <div>
            <div class="name-row">
                <h3>{{ mb_strtoupper($profil->nama) }}</h3>
                @if ($pendidikan?->semester_saat_ini)
                    <span class="lv">LV {{ $pendidikan->semester_saat_ini }}</span>
                @endif
            </div>
            <div class="cls-line">Class: {{ $profil->kelas_karakter }}</div>

            <p class="dialog">{!! $profil->ringkasan_html !!}<span class="blink"> ▼</span></p>

            <div class="bars">
                @foreach ($bar as $b)
                    <div class="bar">
                        <span class="lbl">{{ $b['label'] }}</span>
                        <div class="track"><div class="fill" style="width:{{ (int) $b['persen'] }}%;--c:var(--{{ $b['warna'] }})"></div></div>
                        <span class="val">{{ $b['nilai'] }}</span>
                    </div>
                @endforeach
            </div>

            <div class="counts">
                @foreach ($ringkasan as $r)
                    <div class="count"><b>{{ $r['angka'] }}</b>{{ $r['label'] }}</div>
                @endforeach
            </div>
        </div>
    </div>
</section>
