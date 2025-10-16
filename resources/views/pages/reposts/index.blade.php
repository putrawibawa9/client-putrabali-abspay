@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 shadow rounded">
    <h2 class="text-xl font-bold mb-4">Daftar Repost Guru</h2>

    <a href="{{ route('repost-proofs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Upload Baru</a>

    @if(!empty($data))
        <ul class="divide-y">
            @foreach($data as $item)
                <li class="py-2">
                    Guru ID {{ $item['teacher_id'] }} — Total: {{ $item['count'] ?? '-' }}
                    <a href="{{ route('repost-proofs.show', $item['teacher_id']) }}" class="text-blue-600 underline ml-2">Lihat Detail</a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">Belum ada data repost.</p>
    @endif
</div>
@endsection
