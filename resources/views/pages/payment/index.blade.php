@extends('layouts.main')

@section('content')
    <div class="p-4 bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <!-- Breadcrumb -->
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Payments</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All Students</h1>
            </div>

            <!-- Search Section - Fully Responsive -->
            <div class="w-full mb-4">
                <form class="w-full" action="{{ route('payments.search') }}" method="GET">
                    <label for="student-search" class="sr-only">Search</label>
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-0">
                        <!-- Search Input -->
                        <div class="relative flex-1">
                            <input type="text" name="search" id="student-search" value="{{ $search ?? '' }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg sm:rounded-r-none focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 pr-20 sm:pr-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Cari Siswa berdasarkan NIS atau Nama...">
                            <!-- Mobile Search Button (inside input) -->
                            <button type="submit" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 text-xs font-medium text-white bg-primary-600 rounded hover:bg-primary-700 focus:ring-2 focus:ring-primary-300 focus:outline-none sm:hidden">
                                Search
                            </button>
                        </div>
                        
                        <!-- Desktop Search Button -->
                        <button type="submit" 
                            class="hidden sm:inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-primary-600 border border-primary-600 rounded-r-lg hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            Search
                        </button>

                        <!-- Clear Search Button -->
                        @if(isset($search) && $search != '')
                            <a href="/payments"
                                class="inline-flex items-center justify-center px-3 py-2.5 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg sm:rounded-l-none sm:border-l-0 hover:bg-gray-100 hover:text-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                                </svg>
                                <span class="hidden sm:inline">Clear</span>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="flex flex-1 flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-2 sm:p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Aksi
                                </th>
                                <th scope="col" class="p-2 sm:p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    NIS
                                </th>
                                <th scope="col" class="p-2 sm:p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Nama
                                </th>
                                <th scope="col" class="hidden sm:table-cell p-2 sm:p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    WhatsApp Number
                                </th>
                                <th scope="col" class="hidden md:table-cell p-2 sm:p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Gender
                                </th>
                                <th scope="col" class="hidden lg:table-cell p-2 sm:p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    School
                                </th>
                                <th scope="col" class="hidden lg:table-cell p-2 sm:p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Enroll Date
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($students['data'] as $student)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-2 sm:p-4 whitespace-nowrap">
                                        <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                            <a href="{{ route('payments.show', $student['id']) }}"
                                                class="inline-flex items-center justify-center px-2 py-1 sm:px-3 sm:py-2 text-xs sm:text-sm font-medium text-center text-white bg-primary-600 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 sm:mr-2" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="M3 10c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v4c0 1.1-.9 2-2 2H5a2 2 0 0 1-2-2v-4Zm2 0h14v4H5v-4Zm3 2a2 2 0 1 0 4 0 2 2 0 0 0-4 0Zm7 0h3" />
                                                </svg>
                                                <span class="hidden sm:inline">Buat Pembayaran</span>
                                                <span class="sm:hidden">Bayar</span>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="p-2 sm:p-4 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $student['nis'] }}
                                    </td>

                                    <td class="p-2 sm:p-4 text-sm font-medium text-gray-900 dark:text-white">
                                        <div class="max-w-[120px] sm:max-w-none truncate sm:whitespace-nowrap text-primary-400 hover:underline">
                                            <a href="{{ route('students.show', $student['id']) }}">
                                                {{ $student['name'] }}
                                            </a>
                                        </div>
                                        <!-- Mobile-only additional info -->
                                        <div class="sm:hidden text-xs text-gray-500 mt-1 space-y-1">
                                            <div>📱 <a href="https://wa.me/{{ $student['wa_number'] }}" class="text-primary-600">{{ $student['wa_number'] }}</a></div>
                                            <div class="md:hidden">👤 {{ $student['gender'] }}</div>
                                            <div class="lg:hidden">🏫 {{ Str::limit($student['school'], 20) }}</div>
                                            <div class="lg:hidden">📅 {{ $student['enroll_date'] }}</div>
                                        </div>
                                    </td>

                                    <td class="hidden sm:table-cell p-2 sm:p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="https://wa.me/{{ $student['wa_number'] }}" class="text-primary-600 hover:underline">
                                            {{ $student['wa_number'] }}
                                        </a>
                                    </td>

                                    <td class="hidden md:table-cell p-2 sm:p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $student['gender'] }}
                                    </td>

                                    <td class="hidden lg:table-cell p-2 sm:p-4 text-sm font-medium text-gray-900 dark:text-white">
                                        <div class="max-w-[150px] truncate" title="{{ $student['school'] }}">
                                            {{ $student['school'] }}
                                        </div>
                                    </td>

                                    <td class="hidden lg:table-cell p-2 sm:p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $student['enroll_date'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination Section -->
    <div class="sticky bottom-0 right-0 w-full p-4 bg-white border-t border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <!-- Results Info -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center justify-center sm:justify-start">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400 text-center sm:text-left">
                    Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $students['from'] }}-{{ $students['to'] }}</span> 
                    of <span class="font-semibold text-gray-900 dark:text-white">{{ $students['total'] }}</span> Data
                </span>
            </div>

            <!-- Pagination Controls -->
            <div class="flex items-center justify-center space-x-1 sm:space-x-3">
                @php
                    $baseUrl = isset($search) && $search != '' ? "?search={$search}&page=" : "?page=";
                @endphp

                @if ($students['prev_page_url'])
                    <!-- Previous Button -->
                    <a href="{{ isset($search) && $search != '' ? "?search={$search}&page=" . ($students['current_page'] - 1) : "?page=" . ($students['current_page'] - 1) }}"
                        class="inline-flex items-center justify-center px-2 py-1 sm:px-3 sm:py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="hidden sm:inline">Previous</span>
                    </a>
                @endif

                <!-- Page Numbers (Desktop only) -->
                <div class="hidden sm:flex items-center space-x-1">
                    @if($students['current_page'] > 2)
                        <a href="{{ isset($search) && $search != '' ? "?search={$search}&page=1" : "?page=1" }}" 
                           class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            1
                        </a>
                        @if($students['current_page'] > 3)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif

                    @if($students['current_page'] > 1)
                        <a href="{{ isset($search) && $search != '' ? "?search={$search}&page=" . ($students['current_page'] - 1) : "?page=" . ($students['current_page'] - 1) }}" 
                           class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $students['current_page'] - 1 }}
                        </a>
                    @endif

                    <span class="px-3 py-2 text-sm font-medium text-white bg-primary-600 border border-primary-600 rounded-lg">
                        {{ $students['current_page'] }}
                    </span>

                    @if($students['next_page_url'])
                        <a href="{{ isset($search) && $search != '' ? "?search={$search}&page=" . ($students['current_page'] + 1) : "?page=" . ($students['current_page'] + 1) }}" 
                           class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $students['current_page'] + 1 }}
                        </a>
                    @endif

                    @if($students['last_page'] > $students['current_page'] + 1)
                        @if($students['last_page'] > $students['current_page'] + 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ isset($search) && $search != '' ? "?search={$search}&page=" . $students['last_page'] : "?page=" . $students['last_page'] }}" 
                           class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $students['last_page'] }}
                        </a>
                    @endif
                </div>

                @if ($students['next_page_url'])
                    <!-- Next Button -->
                    <a href="{{ isset($search) && $search != '' ? "?search={$search}&page=" . ($students['current_page'] + 1) : "?page=" . ($students['current_page'] + 1) }}"
                        class="inline-flex items-center justify-center px-2 py-1 sm:px-3 sm:py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <span class="hidden sm:inline">Next</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>

@endsection