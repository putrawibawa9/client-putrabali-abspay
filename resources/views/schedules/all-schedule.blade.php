@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto mt-8 text-white">

    {{-- <h1 class="text-3xl font-bold mb-6">
        Jadwal Guru (ID: {{ $teacherId }})
    </h1> --}}

  {{-- FILTER FORM --}}
<form method="GET"
     
      class="bg-gray-800 p-4 rounded-lg mb-8">

    {{-- GURU --}}
        <div>
            <label class="block text-sm text-gray-300 mb-1">
                Guru
            </label>
            <select name="teacher_id"
                    class="w-full px-3 py-2 rounded
                           bg-gray-700 text-white
                           border border-gray-600
                           focus:ring focus:ring-blue-500">
                <option value="">Semua Guru</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher['id'] }}"
                        {{ request('teacher_id') == $teacher['id'] ? 'selected' : '' }}>
                        {{ $teacher['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- START DATE --}}
        <div>
            <label class="block text-sm text-gray-300 mb-1">
                Dari Tanggal
            </label>
            <input type="date"
                   name="start_date"
                   value="{{ request('start_date') }}"
                   class="w-full px-3 py-2 rounded
                          bg-gray-700 text-white
                          border border-gray-600
                          focus:ring focus:ring-blue-500">
        </div>

        {{-- END DATE --}}
        <div>
            <label class="block text-sm text-gray-300 mb-1">
                Sampai Tanggal
            </label>
            <input type="date"
                   name="end_date"
                   value="{{ request('end_date') }}"
                   class="w-full px-3 py-2 rounded
                          bg-gray-700 text-white
                          border border-gray-600
                          focus:ring focus:ring-blue-500">
        </div>

        {{-- COURSE --}}
        <div>
            <label class="block text-sm text-gray-300 mb-1">
                Kelas
            </label>
            <select name="course_id"
                    class="w-full px-3 py-2 rounded
                           bg-gray-700 text-white
                           border border-gray-600
                           focus:ring focus:ring-blue-500">
                <option value="">Semua Kelas</option>
                @foreach ($courses as $course)
                    <option value="{{ $course['id'] }}"
                        {{ request('course_id') == $course['id'] ? 'selected' : '' }}>
                        {{ $course['alias'] }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- SUBMIT --}}
        <div class="flex items-end">
            <button type="submit"
                    class="w-full px-4 py-2 rounded
                           bg-blue-600 hover:bg-blue-700
                           text-white font-semibold">
                Filter
            </button>
        </div>

    </div>
</form>

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
