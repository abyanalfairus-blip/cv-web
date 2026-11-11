{{-- 05 · Sertifikat (tabel: sertifikat) --}}
<section id="loot" aria-labelledby="h-loot">
    <div class="sec-h"><span class="stage">05</span><h2 id="h-loot">LOOT · SERTIFIKAT</h2></div>

    <div class="loot">
        @foreach ($profil->sertifikat as $s)
            <article class="px card {{ $s->kelangkaan }}">
                <div class="rar">{{ strtoupper($s->kelangkaan) }} · {{ $s->jenis }}</div>
                <h3>{{ $s->judul }}</h3>
                <p class="by">{{ $s->penerbit }}@if ($s->peran) · {{ $s->peran }}@endif</p>
                @if ($s->keterangan)
                    <p>{{ $s->keterangan }}</p>
                @endif
                <dl>
                    <div><dt>Tanggal</dt><dd>{{ $s->tanggal->translatedFormat('j F Y') }}</dd></div>
                    @if ($s->nomor)
                        <div><dt>No. sertifikat</dt><dd>{{ $s->nomor }}</dd></div>
                    @endif
                </dl>
                @if ($s->ada_file)
                    <a class="code-link" href="{{ asset($s->file) }}" target="_blank" rel="noopener">▶ LIHAT SERTIFIKAT</a>
                @endif
            </article>
        @endforeach
    </div>
</section>
