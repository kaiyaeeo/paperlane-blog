@extends('layouts.paperlane')

@section('title', 'Dashboard - Paperlane')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-16">
        <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
        <p class="text-gray-600">
            Selamat datang di dashboard Paperlane, <strong>{{ auth()->user()->name }}</strong>!
        </p>
    </div>
@endsection