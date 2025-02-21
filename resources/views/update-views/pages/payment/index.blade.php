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
                                <a href="#"
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
                    <div class="w-20 h-20 rounded-full bg-gray-100"></div>

                    <div class="flex-1 flex flex-col justify-center ml-5">
                        <h1 class="text-2xl font-semibold text-gray-700 dark:text-white mb-4">Aprilia Dewi</h1>

                        <ul class="flex items-center gap-6">
                            <li class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span>English - 6sra</span>
                            </li>
                            <li class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span>Mapel - 6sra</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sm:flex flex-col sm:flex-1 min-h-full bg-gray-800">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mt-8">
                    <div
                        class="px-12 py-8 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">English - 6sra</h3>

                        <div class="mt-6">
                            <label for="tanggal"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                            <input type="date" id="tanggal"
                                class="bg-gray-50 border py-3 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 [&::-webkit-calendar-picker-indicator]:dark:filter [&::-webkit-calendar-picker-indicator]:dark:invert"
                                placeholder="" required />
                        </div>

                        <div class="mt-6">
                            <label for="tipe"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe</label>
                            <select id="tipe"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Tipe</option>
                                <option value="1">Pembayaran SPP</option>
                                <option value="2">Modul</option>
                                <option value="3">Pendaftaran</option>
                                <option value="4">Ujian</option>
                            </select>
                        </div>

                        <div class="mt-6">
                            <label for="bulan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bulan</label>
                            <select id="bulan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <div class="mt-6">
                            <label for=""
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Bayar</label>

                            <div class="flex gap-12 mt-4">
                                <div class="flex items-center me-4">
                                    <input id="inline-radio" type="radio" value="" name="inline-radio-group"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="inline-radio"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rp 80.000</label>
                                </div>
                                <div class="flex items-center me-4">
                                    <input checked id="inline-checked-radio" type="radio" value=""
                                        name="inline-radio-group"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="inline-checked-radio"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rp 70.000</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div
                        class="px-12 py-8 mt-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Mapel - 6sra</h3>

                        <div class="mt-6">
                            <label for="tanggal"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                            <input type="date" id="tanggal"
                                class="bg-gray-50 border py-3 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 [&::-webkit-calendar-picker-indicator]:dark:filter [&::-webkit-calendar-picker-indicator]:dark:invert"
                                placeholder="" required />
                        </div>

                        <div class="mt-6">
                            <label for="tipe"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe</label>
                            <select id="tipe"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Tipe</option>
                                <option value="1">Tipe 1</option>
                                <option value="2">Tipe 2</option>
                                <option value="3">Tipe 3</option>
                                <option value="4">Tipe 4</option>
                            </select>
                        </div>

                        <div class="mt-6">
                            <label for="bulan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bulan</label>
                            <select id="bulan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <div class="mt-6">
                            <label for=""
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Bayar</label>

                            <div class="flex gap-12 mt-4">
                                <div class="flex items-center me-4">
                                    <input id="inline-radio" type="radio" value="" name="inline-radio-group"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="inline-radio"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rp 80.000</label>
                                </div>
                                <div class="flex items-center me-4">
                                    <input checked id="inline-checked-radio" type="radio" value=""
                                        name="inline-radio-group"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="inline-checked-radio"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rp 70.000</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div
                    class="flex items-center {{ $classes == 2 ? 'justify-end' : 'justify-start' }} w-full h-full my-12 flex-1">
                    <button type="button"
                        class="inline-flex items-center justify-center gap-2 px-8 py-2 text-sm font-semibold text-white bg-primary-700 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition-all dark:focus:ring-offset-gray-800">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z" />
                        </svg>

                        <span>Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
