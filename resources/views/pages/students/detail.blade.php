{{-- @dd($student) --}}
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Student
                                    Detail</span>
                            </div>
                        </li>
                    </ol>
                </nav>
               <div class="bg-gray-200 dark:bg-gray-700 w-full py-6 px-8 flex items-center rounded">
    <div class="flex-1 flex flex-col justify-center ml-5">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-white mb-4">{{ $student['name'] }}</h1>

        <ul class="flex items-center gap-6">
            @forelse ($student['active_courses'] as $row)
            <li class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                <div class="flex flex-col">
                    <span>{{ $row['subject'] }} - {{ $row['alias'] }}</span>
                    <!-- Drop Out Button -->
                    <form action="{{ route('student-course.destroy', $row['pivot']['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to drop out from this course?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition-all dark:focus:ring-offset-gray-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>Drop Out</span>
                        </button>
                    </form>
                </div>
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
            </li>
            @endforelse
        </ul>
    </div>
    
    <!-- Enroll to New Class Button -->
    <div class="ml-auto">
         <button type="button"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-all dark:focus:ring-offset-gray-800"
                        data-modal-toggle="enroll-modal">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
                        Enroll to a New Course
                    </button>
                    
    </div>
</div>
            </div>
            <div class="sm:flex flex-col sm:flex-1 min-h-full">
                <div class="flex items-center justify-between w-full mt-12">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Payment</h2>

                    <a href="{{ route('formPembayaran.print', $student['id']) }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-primary-700 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition-all dark:focus:ring-offset-gray-800">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span>Print Payment Form</span>
                    </a>
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

     <!-- Add User Modal -->
    <div class="fixed bg-gray-200/50 dark:bg-gray-800/50 left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full"
        id="enroll-modal">
        <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold dark:text-white">
                        Enroll to a new course
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                        data-modal-toggle="enroll-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
          <form action="{{ route('student-course.store') }}" method="POST">

    @csrf
    <input type="hidden" name="student_id" value="{{ $student['id'] }}">
    <div class="p-6 space-y-6">
        <div class="grid grid-cols-6 gap-6">
            
            <!-- English Course -->
            <div class="col-span-6 sm:col-span-3">
                <label for="english_course" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">English Course</label>
                <select name="courses[0][course_id]" id="english_course" 
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="">Select English Course</option>
                    @foreach ($englishCourses as $course)
                        <option value="{{ $course['id'] }}">{{ $course['alias'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="english_payment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount Rate</label>
                <input type="number" name="courses[0][custom_payment_rate]" id="english_payment" 
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Enter Discount Rate">
            </div>

            <!-- Mapel Course -->
            <div class="col-span-6 sm:col-span-3">
                <label for="mapel_course" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mapel Course</label>
                <select name="courses[1][course_id]" id="mapel_course" 
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="">Select Mapel Course</option>
                    @foreach ($mapelCourses as $course)
                        <option value="{{ $course['id'] }}">{{ $course['alias'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="mapel_payment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount Rate</label>
                <input type="number" name="courses[1][custom_payment_rate]" id="mapel_payment" 
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Enter Discount Rate">
            </div>
        </div>
    </div>
    <!-- Modal Footer -->
    <div class="items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
        <button
            class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
            type="submit">Add Student</button>
        <button
            class="text-white bg-amber-400 hover:bg-amber-500 focus:ring-4 focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800"
            type="reset">Reset Form</button>
    </div>
</form>


            </div>
        </div>
    </div>
    
@endsection
