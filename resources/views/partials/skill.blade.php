{{-- 03 · Skill tree (tabel: kategori_skill, skill, pengalaman_skill) --}}
<section id="skill" aria-labelledby="h-skill">
    <div class="sec-h"><span class="stage">03</span><h2 id="h-skill">SKILL TREE</h2></div>
    <p class="legend">■ = jumlah quest yang memakai skill ini</p>

    <div class="skills">
        @foreach ($profil->kategoriSkill as $kategori)
            <div class="px branch">
                <h3>{{ $kategori->nama }}</h3>
                @foreach ($kategori->skill as $s)
                    @php $dipakai = $s->pengalaman; @endphp
                    <div class="node">
                        <span class="nm">{{ $s->nama }}</span>
                        <span class="pips" data-n="{{ $dipakai->count() }}" aria-label="{{ $dipakai->count() }} quest"></span>
                        <span class="use">{{ $dipakai->isNotEmpty() ? $dipakai->map(fn ($p) => $p->singkatan ?: $p->judul)->implode(', ') : $s->keterangan }}</span>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
