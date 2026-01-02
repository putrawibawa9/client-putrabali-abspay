@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white">Jadwal Mengajar</h2>
            <p class="mt-2 text-lg text-gray-300">
                <span class="font-semibold text-blue-400">
                    {{ $teacher['name'] }}
                </span>
            </p>

            <div class="mt-4 inline-block bg-gray-800 border border-gray-700 px-5 py-2 rounded-md text-white">
                <span class="font-medium">Total Kelas Akan Datang:</span>
                <span class="font-bold text-blue-400">{{ count($schedule) }}</span>
            </div>
        </div>

        <!-- Daily / Future Schedule Cards -->
        <div class="space-y-4">

            @php
                $days = [
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu',
                    'Sunday' => 'Minggu',
                ];
            @endphp

            @forelse ($schedule as $meet)

            <div class="bg-gray-800 border border-gray-700 rounded-lg p-5 shadow-lg hover:bg-gray-750 transition">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">

                    <div>
                        <p class="text-lg font-bold text-blue-400">
                            {{ $meet['course']['alias'] }}
                        </p>

                        <p class="text-gray-300 text-sm mt-1">
                            {{ \Carbon\Carbon::parse($meet['date'])->translatedFormat('d F Y') }}
                            ({{ $days[$meet['day']] ?? $meet['day'] }})
                        </p>

                        <p class="text-gray-400 text-sm mt-1">
                            Jam: <span class="text-white">{{ $meet['time'] }}</span>
                        </p>

                        @if(!empty($meet['location']))
                        <p class="text-gray-400 text-sm mt-1">
                            Ruangan: <span class="text-blue-300">{{ $meet['location'] }}</span>
                        </p>
                        @endif
                    </div>

                    <div class="mt-4 sm:mt-0 flex items-center">
                        <span class="text-white bg-blue-600 px-3 py-1 rounded-md text-sm font-semibold">
                            Mengajar
                        </span>
                    </div>

                </div>
            </div>

            @empty

            <div class="bg-gray-800 border border-gray-700 rounded-lg p-5 text-center text-gray-300">
                Tidak ada jadwal mengajar yang akan datang.
            </div>

            @endforelse

        </div>

    </div>
</div>
@endsection
