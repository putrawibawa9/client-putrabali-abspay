@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto mt-8 text-white">

    <h1 class="text-3xl font-bold mb-6">
        Jadwal Harian – {{ $schedule['day'] }} ({{ $schedule['date'] }})
    </h1>

    {{-- Form pilih tanggal --}}
    <form action="{{ route('schedule.daily') }}" method="GET" class="mb-6 flex items-center gap-3">
        <div>
            <label class="block text-sm mb-1 font-semibold">Pilih Tanggal</label>
            <input type="date" name="date" value="{{ $schedule['date'] }}"
                   class="px-3 py-2 rounded bg-gray-800 text-white border border-gray-700">
        </div>

        <button type="submit"
                class="mt-6 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
            Lihat
        </button>
    </form>

    {{-- Tidak ada jadwal --}}
    @if ($schedule['count'] === 0)
        <p class="text-gray-400">Tidak ada jadwal mengajar hari ini.</p>
    @endif

    {{-- Group by hour --}}
    @php
        $grouped = collect($schedule['data'])->groupBy('time');
    @endphp

    <div class="space-y-6">
        @foreach ($grouped as $time => $items)
            <div class="bg-gray-900 border border-gray-700 rounded-lg p-4">

                <h2 class="text-xl font-bold mb-3 text-blue-400">
                    {{ $time }}
                </h2>

                <div class="space-y-2">
                    @foreach ($items as $m)
                        <div class="flex justify-between items-center bg-gray-800 rounded px-4 py-2">
                            <div>
                                <p class="font-semibold text-white">
                                    {{ $m['course']['alias'] ?? '-' }}
                                </p>
                                <p class="text-gray-300 text-sm">
                                    {{ $m['teacher']['name'] ?? '-' }}
                                </p>
                            </div>

                            <span class="text-sm bg-gray-700 px-3 py-1 rounded">
                                {{ $m['location'] ?? '-' }}
                            </span>
                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach
    </div>

</div>
@endsection
