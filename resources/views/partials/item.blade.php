{{-- 04 · Inventory & achievement (tabel: peralatan, pencapaian) --}}
<section id="item" aria-labelledby="h-item">
    <div class="sec-h"><span class="stage">04</span><h2 id="h-item">INVENTORY</h2></div>

    <div class="px inv">
        @foreach ($profil->peralatan as $it)
            <div class="slot"><span class="ic">{{ $it->ikon }}</span><b>{{ $it->nama }}</b><span>{{ $it->keterangan }}</span></div>
        @endforeach
    </div>

    <div class="sec-h" style="margin-top:40px"><span class="stage">★</span><h2>ACHIEVEMENT UNLOCKED</h2></div>

    <div class="ach">
        @foreach ($profil->pencapaian as $a)
            <div class="px badge">
                <div class="medal">{{ $a->ikon }}</div>
                <div><b>{{ $a->judul }}</b><span>{{ $a->keterangan }}</span></div>
            </div>
        @endforeach
    </div>
</section>
