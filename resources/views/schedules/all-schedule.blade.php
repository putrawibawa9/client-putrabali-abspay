@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto mt-8 text-white">

    {{-- <h1 class="text-3xl font-bold mb-6">
        Jadwal Guru (ID: {{ $teacherId }})
    </h1> --}}

    {{-- FILTER TABS --}}
    {{-- <div class="flex space-x-3 mb-8">
        <a href="{{ route('teacher.schedule', ['id' => $teacherId, 'type' => 'future']) }}"
           class="px-4 py-2 rounded 
                  {{ $type=='future' ? 'bg-blue-600' : 'bg-gray-700 hover:bg-gray-600' }}">
            Future
        </a>

        <a href="{{ route('teacher.schedule', ['id' => $teacherId, 'type' => 'history']) }}"
           class="px-4 py-2 rounded 
                  {{ $type=='history' ? 'bg-blue-600' : 'bg-gray-700 hover:bg-gray-600' }}">
            History
        </a>

        <a href="{{ route('teacher.schedule', ['id' => $teacherId, 'type' => 'all']) }}"
           class="px-4 py-2 rounded
                  {{ $type=='all' ? 'bg-blue-600' : 'bg-gray-700 hover:bg-gray-600' }}">
            Semua
        </a>
    </div> --}}

    {{-- JIKA KOSONG --}}

 


    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-900 border border-gray-700 rounded-lg">
            <thead class="bg-gray-800 border-b border-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Guru</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Hari</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Jam</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kelas</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Ruangan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Catatan</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-800">
                {{-- @dd($schedules) --}}
                @foreach ($schedules as $row)
                <tr class="hover:bg-gray-800 transition">
                       <td class="px-4 py-3">
                        {{ $row['teacher'] }}
                    </td>
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($row['date'])->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $row['day'] }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $row['time'] }}
                    </td>

                    <td class="px-4 py-3 text-blue-400 font-semibold">
                        {{ $row['course_alias'] }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $row['location'] ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
                        @if($row['is_replacement'])
                            <span class="text-yellow-400 text-sm">Guru Pengganti</span>
                        @elseif($row['is_canceled'])
                            <span class="text-red-400 text-sm">Dibatalkan</span>
                        @else
                            <span class="text-green-400 text-sm">Normal</span>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>
@endsection
