@extends('admin.layout')

@section('title', $judul)

@section('content')
    <header class="kepala">
        <div>
            <h1>{{ $judul }}</h1>
            <p class="muted">{{ $baris->count() }} data</p>
        </div>
        <a class="tombol" href="{{ route("admin.$route.create") }}">+ Tambah {{ strtolower($judul) }}</a>
    </header>

    <div class="panel tabel-wrap">
        @if ($baris->isEmpty())
            <p class="kosong">Belum ada data. Klik <b>Tambah</b> untuk mengisi.</p>
        @else
            <table class="tabel">
                <thead>
                    <tr>
                        @foreach ($kolom as $k)
                            <th>{{ $k }}</th>
                        @endforeach
                        <th class="aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($baris as $b)
                        <tr>
                            @foreach ($b['sel'] as $sel)
                                <td>{{ \Illuminate\Support\Str::limit((string) $sel, 70) }}</td>
                            @endforeach
                            <td class="aksi">
                                <a class="tombol kecil sekunder" href="{{ route("admin.$route.edit", $b['id']) }}">Ubah</a>
                                <form method="POST" action="{{ route("admin.$route.destroy", $b['id']) }}"
                                      onsubmit="return confirm('Hapus data ini? Tindakan ini tidak bisa dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="tombol kecil bahaya" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
