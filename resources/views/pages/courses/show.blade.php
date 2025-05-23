{{-- @dd($students) --}}
@extends('layouts.main')

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="/courses"
                                    class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Courses</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="#"
                                    class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Meetings</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">
                                    Students</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Kelas {{ $students['alias'] }}</h1>
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Jumlah siswa = {{ $students['studentCount'] }} Siswa</p>


            </div>
           
        
    <div class="flex flex-1 flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Action
                            </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    NIS
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Name
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Sekolah
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Wa Number
                                </th>
                                
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                   Gender
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                   Tanggal Daftar
                                </th>
                                
                              
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ( $students['students'] as $student )
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">    

                                    <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
           
                                        <form action="/students/{{ $student['id'] }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" disabled
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                                                Keluarkan
                                            </button>
                                        </form>     
                                        </td> 
        <!-- NIS Column -->
        <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
            {{ $student['nis'] }}
        </td>
        <!-- Name Column -->
        <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
            {{ $student['name'] }}
        </td>                
        <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
            {{ $student['school'] }}
        </td> 
        <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
            <a href="https://wa.me/{{ $student['wa_number'] }}"> {{ $student['wa_number'] }} </a>
        </td>
        
      
        <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
            {{ $student['gender'] }}
        </td>
        <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
            {{ $student['enroll_date'] }}
        </td>

        
        <!-- Action Column -->
           
    </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                        No students found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
