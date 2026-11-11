<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>CV {{ $profil->nama }}</title>
<style>
    /* Template CV formal untuk DomPDF (A4). DomPDF tidak mendukung flex/grid, jadi tata letak memakai tabel. */
    @page { margin: 34px 44px 46px 44px; }
    body { margin: 0; padding: 0; font-family: "DejaVu Sans", sans-serif; font-size: 9.2pt; line-height: 1.45; color: #23222e; }

    div, table, td { margin: 0; padding: 0; }
    .kepala { border-bottom: 3px solid #2a2766; padding-bottom: 10px; margin-bottom: 4px; }
    .nama { font-size: 22pt; font-weight: bold; color: #2a2766; letter-spacing: 0.5px; line-height: 1.1; }
    .peran { font-size: 10.5pt; color: #b07d12; font-weight: bold; margin-top: 3px; }
    .kontak { margin-top: 7px; font-size: 8.4pt; color: #4a4960; }
    .kontak span { white-space: nowrap; }
    .sep { color: #b9b7cc; padding: 0 4px; }

    h2 {
        font-size: 10pt; color: #2a2766; text-transform: uppercase; letter-spacing: 1.2px;
        border-bottom: 1px solid #d9d7e6; padding-bottom: 2px; margin: 14px 0 7px;
    }
    p { margin: 0 0 3px; }
    b { color: #2a2766; }

    table.item { width: 100%; border-collapse: collapse; }
    table.item td { vertical-align: top; padding: 0; }
    td.kanan { text-align: right; white-space: nowrap; width: 34%; color: #5d5c73; font-size: 8.4pt; }
    .judul { font-weight: bold; font-size: 9.8pt; color: #23222e; }
    .sub { color: #5d5c73; font-size: 8.6pt; }
    .entri { margin-bottom: 8px; page-break-inside: avoid; }
    ul { margin: 2px 0 0 14px; padding: 0; }
    li { margin-bottom: 1px; }
    .tek { font-size: 8.2pt; color: #5d5c73; margin-top: 2px; }
    .tek b { color: #5d5c73; }
    .status { font-size: 7.6pt; color: #b07d12; font-weight: bold; }

    table.skill { width: 100%; border-collapse: collapse; }
    table.skill td { padding: 2px 0; vertical-align: top; }
    table.skill td.kat { width: 27%; font-weight: bold; color: #2a2766; font-size: 8pt; letter-spacing: 0.5px; }

    .kaki { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 7.4pt; color: #9a99ad; }
</style>
</head>
<body>

{{-- ================= KEPALA ================= --}}
<div class="kepala">
    <div class="nama">{{ $profil->nama }}</div>
    <div class="peran">{{ \Illuminate\Support\Str::before($profil->subjudul, ' — ') }}</div>
    <div class="kontak">
        @if ($profil->domisili)
            <span>{{ $profil->domisili }}</span><span class="sep">|</span>
        @endif
        @foreach ($profil->kontak as $k)
            <span>{{ $k->teks }}</span>@if (! $loop->last)<span class="sep">|</span>@endif
        @endforeach
    </div>
</div>

{{-- ================= PROFIL ================= --}}
<h2>Profil</h2>
<p>{!! $profil->ringkasan_html !!}</p>

{{-- ================= PENDIDIKAN ================= --}}
@if ($profil->pendidikan->isNotEmpty())
    <h2>Riwayat Pendidikan</h2>
    @foreach ($profil->pendidikan as $p)
        <div class="entri">
            <table class="item"><tr>
                <td>
                    <div class="judul">{{ $p->institusi }}</div>
                    <div class="sub">{{ $p->jenjang }} {{ $p->jurusan }}</div>
                </td>
                <td class="kanan">
                    @if ($p->tahun_masuk || $p->tahun_lulus)
                        {{ $p->tahun_masuk ?? '' }}{{ $p->tahun_masuk ? ' – ' : '' }}{{ $p->tahun_lulus ?? ($p->status === 'berjalan' ? 'sekarang' : '') }}<br>
                    @endif
                    @if ($p->status === 'berjalan')
                        {{ $p->semester_saat_ini ? 'Semester ' . $p->semester_saat_ini . ', ' : '' }}sedang berjalan
                    @else
                        Lulus
                    @endif
                </td>
            </tr></table>
            @if ($p->mataKuliah->isNotEmpty())
                <div class="tek"><b>Mata kuliah relevan:</b> {{ $p->mataKuliah->pluck('nama')->implode(', ') }}</div>
            @endif
        </div>
    @endforeach
@endif

{{-- ================= PENGALAMAN (per jenis) ================= --}}
@foreach ($pengalaman as $grup)
    <h2>{{ $grup['judul'] }}</h2>
    @foreach ($grup['data'] as $q)
        <div class="entri">
            <table class="item"><tr>
                <td>
                    <div class="judul">{{ $q->judul }}</div>
                    @if ($q->instansi)
                        <div class="sub">{{ $q->instansi }}</div>
                    @endif
                </td>
                <td class="kanan">
                    {{ $q->periode }}
                    @if ($q->status === 'berjalan')
                        @if ($q->periode)<br>@endif<span class="status">BERJALAN</span>
                    @endif
                </td>
            </tr></table>

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

            @if ($q->skill->isNotEmpty() || $q->url_kode)
                <div class="tek">
                    @if ($q->skill->isNotEmpty())
                        <b>Teknologi:</b> {{ $q->skill->pluck('nama')->implode(', ') }}
                    @endif
                    @if ($q->url_kode)
                        @if ($q->skill->isNotEmpty())<span class="sep">|</span>@endif
                        <b>Kode:</b> {{ preg_replace('#^https?://#', '', $q->url_kode) }}
                    @endif
                </div>
            @endif
        </div>
    @endforeach
@endforeach

{{-- ================= KEAHLIAN ================= --}}
@if ($profil->kategoriSkill->isNotEmpty())
    <h2>Keahlian</h2>
    <table class="skill">
        @foreach ($profil->kategoriSkill as $kategori)
            <tr>
                <td class="kat">{{ $kategori->nama }}</td>
                <td>{{ $kategori->skill->pluck('nama')->implode(', ') }}</td>
            </tr>
        @endforeach
        @if ($profil->peralatan->isNotEmpty())
            <tr>
                <td class="kat">Tools</td>
                <td>{{ $profil->peralatan->pluck('nama')->implode(', ') }}</td>
            </tr>
        @endif
    </table>
@endif

{{-- ================= SERTIFIKAT ================= --}}
@if ($profil->sertifikat->isNotEmpty())
    <h2>Sertifikat &amp; Pelatihan</h2>
    @foreach ($profil->sertifikat as $s)
        <div class="entri">
            <table class="item"><tr>
                <td>
                    <div class="judul">{{ $s->judul }}</div>
                    <div class="sub">{{ $s->penerbit }}@if ($s->peran) · {{ $s->peran }}@endif</div>
                </td>
                <td class="kanan">
                    {{ $s->tanggal->translatedFormat('j F Y') }}
                    @if ($s->nomor)<br>No. {{ $s->nomor }}@endif
                </td>
            </tr></table>
        </div>
    @endforeach
@endif

<div class="kaki">CV {{ $profil->nama }} · versi web: {{ preg_replace('#^https?://#', '', url('/')) }}</div>

</body>
</html>
