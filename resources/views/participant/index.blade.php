@extends('layouts.participant')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold">Dashboard Participant</h1>
    <p>Halo, {{ Auth::user()->name }}! Selamat datang di sistem.</p>
</div>
@endsection
