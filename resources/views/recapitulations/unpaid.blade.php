{{-- @dd($unpaids) --}}
@extends('layouts.main')

@section('content')
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
         <div class="mb-4">
    {{-- Breadcrumb --}}
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
                        class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Pembayaran</a>
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
                        Murid
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
        {{ $unpaids['course_alias'] ?? 'Semua Kelas' }} 
    </h1>
   

    {{-- Informasi tambahan --}}
    <p class="mt-1 text-sm font-medium text-red-600 dark:text-red-400">
        Belum bayar bulan {{ ucfirst($month ?? now()->format('')) }} :
        {{ $unpaids['count'] ?? 0 }} siswa
    </p>
`
    {{-- Filter Form --}}
    <form method="GET" action="{{ route('unpaid.index') }}" class="mt-4 flex flex-wrap gap-2">
        {{-- Filter Bulan --}}
        <div>
            <label for="month" class="text-sm text-gray-600 dark:text-gray-400">Bulan</label>
            <select name="month" id="month" class="border rounded p-1 text-sm">
                @foreach(range(1,12) as $m)
                    <option value="{{ date('Y-m', mktime(0,0,0,$m,1)) }}"
                        {{ request('month') == date('Y-m', mktime(0,0,0,$m,1)) ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Tahun --}}
        <div>
            <label for="year" class="text-sm text-gray-600 dark:text-gray-400">Tahun</label>
            <select name="year" id="year" class="border rounded p-1 text-sm">
                @for($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- Filter Kelas --}}
        <div>
            <label for="course_id" class="text-sm text-gray-600 dark:text-gray-400">Kelas</label>
            <select name="course_id" id="course_id" class="border rounded p-1 text-sm">
                <option value="">Semua</option>
                @foreach($courses['data'] as $course)
                    <option value="{{ $course['id'] }}"
                        {{ request('course_id') == $course['id'] ? 'selected' : '' }}>
                        {{ $course['alias'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit"
                class="px-3 py-1 text-sm font-medium text-white bg-primary-600 rounded hover:bg-primary-700">
                Filter
            </button>
        </div>
    </form>
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
                              Status
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
                                    Wa Number
                                </th>
                                
                               
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                   Tanggal Daftar
                                </th>
                                
                              
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ( $unpaids['unpaid_students'] as $student )
                           
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">    

                                  
        <!-- NIS Column -->
       <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
        Belum Lunas
    </span>
</td>

        <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
            {{ $student['nis'] }}
        </td>
        <!-- Name Column -->
      <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
    <a href="{{ route('payments.show', $student['id']) }}"
       class="text-white hover:underline dark:text-primary-400">
        {{ $student['name'] }}
    </a>
</td>               
        <td class="p-4 text-base font-medium text-gray-900 dark:text-white whitespace-nowrap">
        <a href="https://wa.me/{{ $student['wa_number'] }}" target="_blank" title="Klik untuk chat di WhatsApp" class="flex items-center gap-1 text-white-600 hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.52 3.48A12.07 12.07 0 0 0 12 0C5.37 0 0 5.37 0 12a11.93 11.93 0 0 0 1.64 6.06L0 24l6.31-1.65A12.07 12.07 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.21-1.25-6.23-3.48-8.52zM12 22a9.93 9.93 0 0 1-5.13-1.41l-.37-.22-3.75.98.99-3.65-.24-.38A9.93 9.93 0 1 1 22 12c0 5.52-4.48 10-10 10zm5.47-7.59c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.27-.47-2.42-1.5-.9-.8-1.5-1.77-1.67-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.5-.5-.67-.5h-.57c-.17 0-.45.07-.68.34-.23.27-.9.88-.9 2.15s.92 2.5 1.05 2.67c.13.17 1.8 2.75 4.37 3.75.61.21 1.09.34 1.46.44.61.16 1.16.14 1.6.09.49-.06 1.5-.61 1.71-1.2.21-.59.21-1.09.15-1.2-.06-.11-.27-.17-.57-.32z"/>
            </svg>
            {{ $student['wa_number'] }}
        </a>
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
