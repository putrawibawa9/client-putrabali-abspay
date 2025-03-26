{{-- @dd($recapitulations) --}}
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Recapitulations</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="sm:flex flex-col sm:flex-1 min-h-full">
                {{-- <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mt-4">Dashboard</h2> --}}

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mt-8 items-end">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Students</h3>

                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4">Enrolled Student This Month
                            </p>
                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $recapitulations['total_enroll_students_in_given_month'] }} Students</h5>
                        </div>
                    </div>

                    <div>
                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4">Total Students
                            </p>
                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $recapitulations['total_students'] }} Students</h5>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mt-8 items-end">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Teachers</h3>

                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4">Total Teachers
                            </p>
                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $recapitulations['total_teachers'] }} Teachers</h5>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Courses</h3>

                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4">Active Courses
                            </p>
                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $recapitulations['total_active_courses'] }} Courses</h5>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 mt-8 items-end">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Payments</h3>

                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            {{-- <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4">Total Pemasukan Bulan Ini
                            </p>

                            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                                class="text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:text-white dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800 mb-6"
                                type="button">Pilih Bulan <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Januari</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Februari</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Maret</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">April</a>
                                    </li>
                                    <li></li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mei</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Juni</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Juli</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Agustus</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">September</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Oktober</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">November</a>
                                    </li>
                                    <li></li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Desember</a>
                                    </li>
                                </ul>
                            </div> --}}

                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total Revenue This Month :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">
    Rp. {{ number_format($recapitulations['total_revenue'], 0, ',', '.') }}
</h5>

                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-16 mt-4 items-end">
                    <div>
                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4"> Students who have paid this month
                            </p>
                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{$recapitulations['total_students_who_paid']}}%</h5>
                        </div>
                    </div>

                    <div>
                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4">Students who have not paid this month
                                Bulan ini
                            </p>
                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{$recapitulations['total_students_who_have_not_paid']}}%</h5>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mt-8 items-end">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Absences</h3>

                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4">Students who are absent this month
                            </p>
                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{$recapitulations['total_students_who_are_absent']}}%</h5>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Meetings</h3>

                        <div
                            class="p-12 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                            <p class="font-normal text-base text-gray-700 dark:text-gray-400 mb-4">Meetings This Month
                                Bulan Ini
                            </p>
                            <p class="font-semibold text-xl text-gray-900 dark:text-white mb-6">Total :</p>
                            <h5 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $recapitulations['total_meetings_in_given_month'] }} Meetings</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
