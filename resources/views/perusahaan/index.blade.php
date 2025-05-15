@extends('layouts.perusahaan')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold">Dashboard Perusahaan</h1>
    <p>Halo, {{ Auth::user()->name }}! Selamat datang di sistem.</p>
</div>
@endsection
