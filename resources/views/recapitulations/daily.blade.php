@extends('layouts.main')

@section('content')
<div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-900 dark:border-gray-700">
    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">Daily Recap</h2>

    <!-- Date Filter Form -->
  <form method="GET" action="{{ route('daily-recap.index') }}" class="mb-6">
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter By Date Range</label>
    <div class="flex flex-col sm:flex-row gap-2 mb-4">
        {{-- Start Date --}}
        <input type="date" id="start_date" name="start_date" 
            value="{{ request('start_date', now()->format('Y-m-01')) }}"
            class="flex-1 sm:max-w-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

        {{-- End Date --}}
        <input type="date" id="end_date" name="end_date" 
            value="{{ request('end_date', now()->format('Y-m-d')) }}"
            class="flex-1 sm:max-w-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

        {{-- Teacher Dropdown --}}
        <select id="teacher_id" name="teacher_id"
            class="flex-1 sm:max-w-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">All Teachers</option>
            @foreach($teachers['data'] as $teacher)
                <option value="{{ $teacher['id'] }}" {{ request('teacher_id') == $teacher['id'] ? 'selected' : '' }}>
                    {{ $teacher['name'] }}
                </option>
            @endforeach
        </select>


        {{-- Lokasi PB --}}
<select id="lokasi_pb" name="lokasi_pb"
    class="flex-1 sm:max-w-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
           focus:ring-blue-500 focus:border-blue-500 p-2.5
           dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    <option value="">All Locations</option>
    <option value="1" {{ request('lokasi_pb') == '1' ? 'selected' : '' }}>
        PB 1
    </option>
    <option value="2" {{ request('lokasi_pb') == '2' ? 'selected' : '' }}>
        PB 2
    </option>
</select>


        {{-- Submit Button --}}
        <button type="submit"
            class="px-4 py-2.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 transition-colors">
            Filter
        </button>
    </div>
</form>



    <!-- Meeting Summary -->
    <div class="mb-4">
         @if($totalMeetings > 0)
            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                Total: {{ $totalMeetings }} meeting{{ $totalMeetings > 1 ? 's' : '' }}
            </div>
        @endif
        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2">
            
            Total Upah Guru:
            <span class="text-blue-600 dark:text-blue-400">Rp. {{ number_format($totalTeacherFee, 0, ',', '.') }} </span>

        </h3>
       
    </div>

    <!-- Meetings Display -->
    @if(count($meetings) > 0)
        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Guru</th>
                        <th class="px-4 py-3">Hari</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Upah</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($meetings) --}}
                    @foreach($meetings as $meeting)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750">
                          @php
    $days = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu',
    ];
@endphp
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
    <a href="{{ route('courses.students', $meeting['course_id']) }}"
       class="text-primary-600 hover:underline dark:text-primary-400">
        {{ $meeting['course_alias'] }}
    </a>
</td>
                      <td class="px-4 py-3">
    <a href="/recap-teacher-absences?id={{ $meeting['teacher_id'] }}"
       class="text-primary-600 hover:underline dark:text-primary-400">
        {{ $meeting['teacher_name'] }}
    </a>
</td>

                        <td class="px-4 py-3">{{ $days[$meeting['day']] ?? $meeting['day'] }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($meeting['date'])->locale('id')->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-3">{{ $meeting['time'] }}</td>
                        <td class="px-4 py-3">{{ $meeting['course_teacher_fee'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (visible only on mobile) -->
        <div class="md:hidden space-y-3">
            @foreach($meetings as $meeting)
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ $meeting['course_alias'] }}
                    </h4>
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                        {{ $meeting['time'] }}
                    </span>
                </div>
                
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-300">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $meeting['teacher_name'] }}</span>
                    </div>
                    
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $meeting['day'] }}, {{ $meeting['date'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m4-10v10m-8-6h12" />
            </svg>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Tidak ada pertemuan yang ditemukan</p>
        </div>
    @endif
</div>
@endsection