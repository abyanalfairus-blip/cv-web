{{-- 06 · Riwayat pendidikan (tabel: pendidikan, mata_kuliah) --}}
<section id="guild" aria-labelledby="h-guild">
    <div class="sec-h"><span class="stage">06</span><h2 id="h-guild">GUILD · PENDIDIKAN</h2></div>

    @foreach ($profil->pendidikan as $p)
        <div class="px guild" @if (! $loop->first) style="margin-top:26px" @endif>
            <div>
                <h3>{{ $p->institusi }}</h3>
                <div class="meta">
                    {{ $p->jenjang }} · {{ $p->jurusan }}
                    @if ($p->status === 'berjalan')
                        @if ($p->semester_saat_ini) · Semester {{ $p->semester_saat_ini }} @endif · sedang berjalan
                    @else
                        · Lulus
                    @endif
                    @if ($p->tahun_masuk || $p->tahun_lulus)
                        · {{ $p->tahun_masuk ?? '?' }}–{{ $p->tahun_lulus ?? ($p->status === 'berjalan' ? 'sekarang' : '?') }}
                    @endif
                </div>
            </div>
            @if ($p->mataKuliah->isNotEmpty())
                <div class="books">
                    @foreach ($p->mataKuliah as $m)
                        <div class="book"><b>{{ $m->nama }}</b><span>{{ $m->keterangan }}</span></div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</section>
