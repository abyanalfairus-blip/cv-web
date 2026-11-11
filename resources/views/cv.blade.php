@extends('layouts.app')

@section('title', 'CV ' . $profil->nama)
@section('description', 'CV ' . $profil->nama . ' — ' . $profil->subjudul)

@section('content')
    @include('partials.judul')
    @include('partials.hud')

    <main>
        @include('partials.status')
        @include('partials.quest')
        @include('partials.skill')
        @include('partials.item')
        @include('partials.loot')
        @include('partials.guild')
        @include('partials.party')
    </main>

    @if ($profil->footer)
        <footer>{{ $profil->footer }}</footer>
    @endif
@endsection
