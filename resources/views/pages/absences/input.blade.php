{{-- @dd($data) --}}
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
                                <a href="/absences"
                                    class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Absences</a>
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Input
                                    Absences</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center justify-center w-full h-40 mb-8">
                  <img class="bg-slate-300 w-28 h-28 rounded-full" src="{{ asset('img/nologo.png') }}" alt="">
                </div>
            </div>
              <div class="sm:flex sm:flex-1 min-h-full">
                <div class="items-center flex-1 mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                 <form class="w-full" action="{{ route('absences.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label for="date" class="sr-only">Date</label>
            <div class="relative mt-1">
                <input type="date" name="date" id="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            </div>
        </div>

        <div>
            <label for="time" class="sr-only">Jam</label>
            <div class="relative mt-1">
                <select name="time" id="time"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" disabled selected>Jam</option>
                    <option value="14:30">14:30</option>
                    <option value="15:50">15:50</option>
                    <option value="17:10">17:10</option>
                    <option value="18:30">18:30</option>
                    <option value="19:50">19:50</option>
                </select>
            </div>
        </div>

        <div>
            <label for="teacher_id" class="sr-only">Guru</label>
            <div class="relative mt-1">
                <select name="teacher_id" id="teacher_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" disabled selected>Guru</option>
                    @foreach ($teachers['data'] as $teacher)
                        <option value="{{ $teacher['id'] }}">{{ $teacher['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <input type="hidden" name="course_id" value="{{ $data['id'] }}">

    <div class="overflow-x-auto p-4 lg:p-0 bg-white dark:bg-gray-800">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <div class="bg-gray-100 dark:bg-gray-700 px-8 py-4 border-b border-gray-400 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400">{{ $data['alias'] }} - {{ $data['subject'] }}</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Student Name
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                Present
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                Absent
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach ($data['students'] as $index => $student)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $student['name'] }}
                                </td>
                                <td class="p-4 text-center">
                                    <input type="hidden" name="attendances[{{ $index }}][students_courses_id]" value="{{ $student['id'] }}">
                                    <input id="radio-{{ $student['id'] }}-1" type="radio" value="present"
                                        name="attendances[{{ $index }}][status]"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </td>
                                <td class="p-4 text-center">
                                    <input id="radio-{{ $student['id'] }}-2" type="radio" value="absent"
                                        name="attendances[{{ $index }}][status]"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-end">
            <button type="submit"
                class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Submit
            </button>
        </div>
    </div>
</form>

    </div>
@endsection
