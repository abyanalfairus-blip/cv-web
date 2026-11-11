{{-- 02 · Quest log (tabel: pengalaman, pengalaman_poin, pengalaman_skill) --}}
<section id="quest" aria-labelledby="h-quest">
    <div class="sec-h"><span class="stage">02</span><h2 id="h-quest">QUEST LOG</h2></div>

    @if ($jenisQuest->count() > 1)
        <div class="filter" role="group" aria-label="Saring jenis pengalaman">
            <button type="button" class="f-btn on" data-jenis="semua">Semua ({{ $profil->pengalaman->count() }})</button>
            @foreach (\App\Models\Pengalaman::JENIS as $kode => $label)
                @if ($jenisQuest->has($kode))
                    <button type="button" class="f-btn" data-jenis="{{ $kode }}">{{ $label }} ({{ $jenisQuest[$kode] }})</button>
                @endif
            @endforeach
        </div>
    @endif

    <div class="quests">
        @forelse ($profil->pengalaman as $q)
            <article class="px quest {{ $q->utama ? 'main' : '' }}" data-jenis="{{ $q->jenis }}">
                <div class="q-top">
                    <span class="rank">{{ $q->label_quest }}</span>
                    @if ($q->status === 'selesai')
                        <span class="state done">CLEARED</span>
                    @else
                        <span class="state go">ON GOING</span>
                    @endif
                    <span class="kind">{{ $q->jenis_label }}</span>
                    <span class="q-where">{{ collect([$q->instansi, $q->periode])->filter()->implode(' · ') }}</span>
                </div>

                <h3>{{ $q->judul }}</h3>

                @if ($q->deskripsi)
                    <p>{{ $q->deskripsi }}</p>
                @endif

                @if ($q->poin->isNotEmpty())
                    <ul>
                        @foreach ($q->poin as $poin)
                            <li>{{ $poin->isi }}</li>
                        @endforeach
                    </ul>
                @endif

                @if ($q->url_kode)
                    <a class="code-link" href="{{ $q->url_kode }}" target="_blank" rel="noopener">▶ LIHAT KODE DI GITHUB</a>
                @endif

                @if ($q->skill->isNotEmpty())
                    <div class="reward">
                        <span>REWARD</span>
                        @foreach ($q->skill as $s)
                            <span class="chip">{{ $s->nama }}</span>
                        @endforeach
                    </div>
                @endif
            </article>
        @empty
            <p class="empty">Belum ada pengalaman.</p>
        @endforelse
    </div>
</section>
