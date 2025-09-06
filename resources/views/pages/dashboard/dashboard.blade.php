
@extends('layouts.main')

@section('content')
    <div class="p-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 lg:mt-1.5">
        <div class="w-full">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Recapitulations</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>


              <!-- Filter Form -->
                <div class="mt-8">
                    <form method="GET" action="/recapitulations" class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-900 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="col-span-1">
                                <label for="month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Month</label>
                                <select id="month" name="month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>

                                   <option value="">-- Select Month --</option>
                                    <option value="january" {{ request('month') == 'january' ? 'selected' : '' }}>January</option>
                                    <option value="february" {{ request('month') == 'february' ? 'selected' : '' }}>February</option>
                                    <option value="march" {{ request('month') == 'march' ? 'selected' : '' }}>March</option>
                                    <option value="april" {{ request('month') == 'april' ? 'selected' : '' }}>April</option>
                                    <option value="may" {{ request('month') == 'may' ? 'selected' : '' }}>May</option>
                                    <option value="june" {{ request('month') == 'june' ? 'selected' : '' }}>June</option>
                                    <option value="july" {{ request('month') == 'july' ? 'selected' : '' }}>July</option>
                                    <option value="august" {{ request('month') == 'august' ? 'selected' : '' }}>August</option>
                                    <option value="september" {{ request('month') == 'september' ? 'selected' : '' }}>September</option>
                                    <option value="october" {{ request('month') == 'october' ? 'selected' : '' }}>October</option>
                                    <option value="november" {{ request('month') == 'november' ? 'selected' : '' }}>November</option>
                                    <option value="december" {{ request('month') == 'december' ? 'selected' : '' }}>December</option>

                                </select>
                            </div>
                            
                            <div class="col-span-1">
                                <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Year</label>
                                <select id="year" name="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                 <option value="">-- Select Year --</option>
@for ($y = 2023; $y <= 2029; $y++)
    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
@endfor

                                </select>
                            </div>
                            
                            <div class="col-span-1 flex items-end">
                                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            <div class="flex flex-col min-h-full">
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-center">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pendaftaran Baru Bulan Ini</h3>
        <p class="text-3xl font-bold text-blue-500 dark:text-blue-400">
            {{ $recapitulations['total_enroll_students_in_given_month'] }}
        </p>
    </div>

    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-center">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Total Siswa</h3>
        <p class="text-3xl font-bold text-green-500 dark:text-green-400">
            {{ $recapitulations['total_students'] }}
        </p>
    </div>
</div>

                <!-- Teachers & Courses Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Guru</h3>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-center">
                            <p class="text-gray-700 dark:text-gray-400 mb-3">Total Guru</p>
                            <p class="font-semibold text-gray-900 dark:text-white mb-2">Total:</p>
                            <h5 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $recapitulations['total_teachers'] }} Guru</h5>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Kelas</h3>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-center">
                            <p class="text-gray-700 dark:text-gray-400 mb-3">Kelas Aktif</p>
                            <p class="font-semibold text-gray-900 dark:text-white mb-2">Total:</p>
                            <h5 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $recapitulations['total_active_courses'] }} Kelas</h5>
                        </div>
                    </div>
                </div>

              

                <!-- Payments Section -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Pembayaran</h3>
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-center">
                       
                        <p class="font-semibold text-xl text-gray-900 dark:text-white mb-2">Pendapatan yang Diharapkan:</p>
                        <h5 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $recapitulations['expected_income'] }}
                        </h5>
                    </div>
                </div>
                <div class="mt-8">
                 
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-center">
                       
                        <p class="font-semibold text-xl text-gray-900 dark:text-white mb-2">Total Pemasukan Bulan Ini:</p>
                        <h5 class="text-3xl font-bold text-gray-900 dark:text-white">
                            Rp. {{ number_format($recapitulations['total_revenue'], 0, ',', '.') }}
                        </h5>
                    </div>
                </div>

            <div class="mt-6">
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Status Pembayaran Bulan Ini</h3>
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-900 dark:border-gray-700 text-center">
        <div class="flex flex-col sm:flex-row justify-around items-center gap-4">
            <div class="p-4 bg-green-100 dark:bg-green-800 rounded-lg w-full sm:w-1/3">
                <p class="text-lg font-semibold text-green-800 dark:text-green-100">Sudah Dibayar</p>
                <p class="text-2xl font-bold text-green-800 dark:text-green-100">
                    {{ $recapitulations['total_students_who_paid'] }}%
                </p>
            </div>
            <div class="p-4 bg-red-100 dark:bg-red-800 rounded-lg w-full sm:w-1/3">
                <p class="text-lg font-semibold text-red-700 dark:text-red-200">Belum Dibayar</p>
                <p class="text-2xl font-bold text-red-800 dark:text-red-100">
                    {{ $recapitulations['total_students_who_have_not_paid'] }}%
                </p>
            </div>
        </div>
    </div>
</div>


<script>
    const paymentStatusCtx = document.getElementById('paymentStatusChart').getContext('2d');
    new Chart(paymentStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Not Paid'],
            datasets: [{
                data: [
                    {{ $recapitulations['total_students_who_paid'] }},
                    {{ $recapitulations['total_students_who_have_not_paid'] }}
                ],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',  // green-500
                    'rgba(239, 68, 68, 0.8)'   // red-500
                ],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw}%`;
                        }
                    }
                }
            }
        }
    });
</script>


                <!-- Absences & Meetings Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8 mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Absences</h3>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-center">
                            <p class="text-gray-700 dark:text-gray-400 mb-3">Students who are absent this month</p>
                            <p class="font-semibold text-gray-900 dark:text-white mb-2">Total:</p>
                            <h5 class="text-3xl font-bold text-gray-900 dark:text-white">{{$recapitulations['total_students_who_are_absent']}}%</h5>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Meetings</h3>
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-center">
                            <p class="text-gray-700 dark:text-gray-400 mb-3">Meetings This Month</p>
                            <p class="font-semibold text-gray-900 dark:text-white mb-2">Total:</p>
                            <h5 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $recapitulations['total_meetings_in_given_month'] }} Meetings</h5>
                        </div>
                    </div>
                </div>
              


                  
                </div>
            </div>
        </div>
    </div>
@endsection