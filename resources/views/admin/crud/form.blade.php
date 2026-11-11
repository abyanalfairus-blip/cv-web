@extends('admin.layout')

@section('title', ($item->exists ? 'Ubah ' : 'Tambah ') . $judul)

@section('content')
    <header class="kepala">
        <div>
            <h1>{{ $item->exists ? 'Ubah' : 'Tambah' }} {{ strtolower($judul) }}</h1>
            @if ($route !== 'profil')
                <a class="muted" href="{{ route("admin.$route.index") }}">← Kembali ke daftar</a>
            @endif
        </div>
    </header>

    @if ($errors->any())
        <div class="flash error" role="alert">Ada {{ $errors->count() }} isian yang perlu diperbaiki.</div>
    @endif

    <form class="panel form" method="POST" action="{{ $aksi }}" enctype="multipart/form-data">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        <div class="form-grid">
            @foreach ($fields as $nama => $f)
                @include('admin.crud.field', ['nama' => $nama, 'f' => $f])
            @endforeach
        </div>

        <div class="form-aksi">
            <button class="tombol" type="submit">Simpan</button>
            @if ($route !== 'profil')
                <a class="tombol sekunder" href="{{ route("admin.$route.index") }}">Batal</a>
            @endif
        </div>
    </form>
@endsection
