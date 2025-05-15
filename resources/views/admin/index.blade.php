@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold">Dashboard Admin</h1>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>
</div>
@endsection
