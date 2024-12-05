{{-- @dd($absenceHistory) --}}
@extends('update-views.layouts.main')

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
                                <a href="/students"
                                    class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Students</a>
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Enroll
                                    Student</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="bg-gray-200 dark:bg-gray-700 w-full py-6 px-8 flex items-center rounded">
                    

                    <div class="flex-1 flex flex-col justify-center ml-5">
                        <h1 class="text-2xl font-semibold text-gray-700 dark:text-white mb-4">{{ $student['name'] }}</h1>

                        <ul class="flex items-center gap-6">
                            @forelse ( $student['active_courses'] as $row)
                                  <li class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span>{{ $row['subject'] }} - {{ $row['alias'] }}</span>
                            </li>
                            @empty
                                  <li class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
            viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M12 2a10 10 0 1 0 0 20 10 10 0 1 0 0-20ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                clip-rule="evenodd" />
        </svg>
        <span>No active courses available</span>
                            @endforelse
                           
                              
                        
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sm:flex flex-col sm:flex-1 min-h-full">
                <div class="flex items-center justify-between w-full mt-12">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Payment</h2>

                    <button type="button"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-primary-700 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition-all dark:focus:ring-offset-gray-800">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span>Payment Record</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mt-8">
    @if (!empty($payment['course_payments']) && count($payment['course_payments']) > 0)
        @foreach ($payment['course_payments'] as $row)
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <div
                            class="bg-gray-100 dark:bg-gray-700 px-8 py-4 border-b border-gray-400 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400">
                                {{ $row['course']['subject'] }} - {{ $row['course']['alias'] }}
                            </h3>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Type
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Month
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Amount
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Date
                                    </th>
                                </tr>
                            </thead>

                            <tbody
                                class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($row['payments'] as $r)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td
                                            class="p-4 text-base font-medium mr-12 text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $r['type'] }}
                                        </td>
                                        <td
                                            class="p-4 text-base font-medium mr-12 text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $r['payment_month'] }}
                                        </td>
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Rp.{{ number_format($r['payment_amount'], 0, ',','.') }}
                                        </td>
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ \Carbon\Carbon::parse($r['created_at'])->format('d M Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                            No payment records for this course.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-span-1 lg:col-span-2 text-center py-8">
            <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 20l9-5-9-5-9 5 9 5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16"></path>
            </svg>
            <p class="text-lg font-semibold text-gray-600 dark:text-gray-400 mt-4">
                No payment records available
            </p>
        </div>
    @endif
</div>



                <div class="flex items-center justify-between w-full mt-12">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Absence</h2>
                </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mt-8">
    @forelse ($absenceHistory as $absence)
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <div
                        class="bg-gray-100 dark:bg-gray-700 px-8 py-4 border-b border-gray-400 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400">
                            {{ $absence['course']['subject'] }} - {{ $absence['course']['alias'] }}
                        </h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Meeting Date
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Meeting Time
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Absence Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($absence['absences'] as $row)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="p-4 text-base font-medium mr-12 text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $row['meeting_date'] }}
                                    </td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $row['meeting_time'] }}
                                    </td>
                                    <td>
                                        <button
                                            class="py-2 px-8 text-base font-medium {{ $row['status'] === 'present' ? 'bg-green-500' : 'bg-red-500' }} text-white rounded">
                                            {{ $row['status'] }}
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                        No absence records available for this course.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-1 lg:col-span-2 text-center py-8">
            <div class="bg-gray-100 dark:bg-gray-700 p-8 rounded-lg shadow">
                <h2 class="text-2xl font-semibold text-gray-600 dark:text-gray-300">
                    No Absence History Available
                </h2>
                <p class="text-gray-500 dark:text-gray-400 mt-4">
                    It seems like there are no records of absences at the moment. 
                    Please check back later or ensure the data is correctly entered.
                </p>
            </div>
        </div>
    @endforelse
</div>

            </div>
        </div>
    </div>
@endsection
