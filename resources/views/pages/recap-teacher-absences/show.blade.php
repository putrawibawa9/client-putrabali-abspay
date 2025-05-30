{{-- @dd($teacher) --}}
@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white">Riwayat Mengajar</h2>
            <p class="mt-2 text-lg text-gray-300"><span class="font-semibold text-blue-400">{{ $teacher['teacher']['name'] }}</span></p>
       
            <div class="text-white mt-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-700 rounded-md font-semibold text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{-- bulan dan tahun --}}
                {{ $teacher['month'] }}  {{ $teacher['year'] }}
            </div>
        </div>

        <!-- Absence Card -->
        <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Card Header -->
            <div class="px-4 py-5 sm:px-6 bg-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-lg font-medium text-white">
                      Detail 
                    </h3>
                    <span class=" text-white mt-2 sm:mt-0 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-600 text-blue-300">
                        Total: {{ $teacher['total_absences'] }} Pertemuan
                    </span>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Day
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Time
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Course
                            </th>
                        </tr>
                    </thead>
                    @foreach ($teacher['teacher']['meetings'] as $meeting)
                        
                 
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        <tr class="hover:bg-gray-700 transition duration-150">
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                               {{ $meeting['date'] }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $meeting['day'] }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $meeting['time'] }}
                            </td>
                            <td class=" text-white px-4 py-4 whitespace-nowrap text-sm font-medium text-blue-400">
                              {{ $meeting['course']['alias'] }}
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>

     
    </div>
</div>
@endsection