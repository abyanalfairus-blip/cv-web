{{-- Menu HUD lengket di atas --}}
<div class="hud">
    <nav aria-label="Menu">
        @foreach ($menu as $id => $label)
            <a href="#{{ $id }}"><span class="k">{{ $loop->iteration }}</span> {{ $label }}</a>
        @endforeach
        <span class="hint">Tekan 1–{{ count($menu) }} untuk pindah menu</span>

        {{-- Tombol ke panel admin: jika sudah login langsung ke dashboard, jika belum ke halaman login --}}
        <a class="admin-link" href="{{ route('admin.dashboard') }}" title="{{ auth()->check() ? 'Buka panel admin' : 'Login panel admin' }}">
            ⚙ {{ auth()->check() ? 'PANEL ADMIN' : 'ADMIN' }}
        </a>
    </nav>
</div>
