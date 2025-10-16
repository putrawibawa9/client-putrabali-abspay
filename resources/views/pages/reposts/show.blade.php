@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">📊 Statistik Repost Guru</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-3">{{ session('error') }}</div>
    @endif

    @isset($data)
        <div class="border p-4 rounded-lg bg-gray-50">
            <p><strong>Teacher ID:</strong> {{ $data['teacher_id'] }}</p>
            <p><strong>Bulan:</strong> {{ $data['month'] }} {{ $data['year'] }}</p>
            <p><strong>Total Repost:</strong> {{ $data['count'] }}</p>
        </div>
    @else
        <p class="text-gray-500">Belum ada data repost bulan ini.</p>
    @endisset
</div>
@endsection
