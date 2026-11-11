@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <header class="kepala">
        <div>
            <h1>Halo, {{ $profil?->nama ?? auth()->user()->name }}</h1>
            <p class="muted">Semua perubahan di sini langsung tampil di website dan PDF CV.</p>
        </div>
        <div class="aksi-kepala">
            <a class="tombol" href="{{ route('cv') }}" target="_blank" rel="noopener">Buka website ↗</a>
            <a class="tombol sekunder" href="{{ route('cv.download') }}">Unduh PDF</a>
        </div>
    </header>

    <div class="kartu-grid">
        @foreach ($kartu as $k)
            <a class="kartu" href="{{ route($k['route']) }}">
                <span class="angka">{{ $k['jumlah'] }}</span>
                <span class="lbl">{{ $k['label'] }}</span>
            </a>
        @endforeach
    </div>

    <section class="panel">
        <h2>Cara cepat</h2>
        <ul class="tips">
            <li><b>Menambah organisasi:</b> menu Pengalaman → Tambah → pilih jenis <i>Organisasi</i>.</li>
            <li><b>Menghubungkan skill ke proyek:</b> buka pengalaman, centang skill yang dipakai. Kotak hijau di skill tree dan bar status ikut bertambah.</li>
            <li><b>Mengubah urutan tampil:</b> isi kolom <i>Urutan</i> (angka kecil tampil lebih dulu).</li>
        </ul>
    </section>
@endsection
