<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records | Putra Bali English Course</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a365d;
            --secondary: #2c5282;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header, .footer {
            background-color: var(--primary);
            color: white;
        }
        .badge-present {
            background-color: #10b981;
        }
        .badge-absent {
            background-color: #ef4444;
        }
        .card {
            transition: all 0.3s ease;
            border-left: 4px solid var(--secondary);
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .section-title {
            position: relative;
            padding-left: 1rem;
        }
        .section-title:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--primary);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <header class="header py-4 shadow-md">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl md:text-2xl font-bold">
                <i class="fas fa-graduation-cap mr-2"></i>Putra Bali English Course
            </h1>
            <div class="text-sm">
                <i class="fas fa-calendar-day mr-1"></i> {{ now()->format('d F Y') }}
            </div>
        </div>
    </header>

    <!-- Student Profile Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                    <i class="fas fa-user-graduate text-blue-600 dark:text-blue-300 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $payment['student']['name'] }}</h2>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="text-sm px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">
                         
                            <i class="fas fa-id-card mr-1"></i> NIS: {{ $payment['student']['nis'] }}
                        </span>
                        <span class="text-sm px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">
                            <i class="fas fa-book mr-1"></i> {{ count($payment['course_payments']) }} Kursus
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Payment Section -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="section-title text-2xl font-semibold text-gray-800 dark:text-white">
                   Riwayat Pembayaran
                </h2>
                
            </div>

            @if (!empty($payment['course_payments']) && count($payment['course_payments']) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach ($payment['course_payments'] as $row)
                        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center">
                                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg mr-4">
                                    <i class="fas fa-book text-blue-600 dark:text-blue-300"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $row['course']['subject'] }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $row['course']['alias'] }}</p>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Month</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($row['payments'] as $r)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                                        {{ $r['type'] }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                                    <i class="far fa-calendar-alt mr-1 text-gray-400"></i> {{ $r['payment_month'] }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                                    <i class="far fa-clock mr-1 text-gray-400"></i> {{ \Carbon\Carbon::parse($r['created_at'])->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <i class="fas fa-wallet text-3xl text-gray-400 mb-2"></i>
                                                        <p>Tidak ada riwayat pembayaran untuk kelas ini</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 text-center">
                    <div class="mx-auto w-24 h-24 bg-blue-50 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-wallet text-3xl text-blue-500 dark:text-blue-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">No Payment Records</h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                        There are no payment records available for this student. Payments will appear here once recorded.
                    </p>
                </div>
            @endif
        </section>

        <!-- Absence Section -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="section-title text-2xl font-semibold text-gray-800 dark:text-white">
                   Riwayat Kehadiran
                </h2>
               
            </div>

            @if (!empty($absenceHistory) && count($absenceHistory) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach ($absenceHistory as $absence)
                        <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center">
                                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-lg mr-4">
                                    <i class="fas fa-clipboard-check text-green-600 dark:text-green-300"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $absence['course']['subject'] }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $absence['course']['alias'] }}</p>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($absence['absences'] as $row)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    <i class="far fa-calendar mr-1 text-gray-400"></i> {{ $row['meeting_date'] }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                                    <i class="far fa-clock mr-1 text-gray-400"></i> {{ $row['meeting_time'] }}
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium badge-{{ $row['status'] }}">
                                                        <i class="fas {{ $row['status'] === 'present' ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                                        {{ ucfirst($row['status']) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <i class="fas fa-clipboard-list text-3xl text-gray-400 mb-2"></i>
                                                        <p>Tidak ada riwayat kehadiran untuk kelas ini</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 text-center">
                    <div class="mx-auto w-24 h-24 bg-green-50 dark:bg-green-900 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-clipboard-list text-3xl text-green-500 dark:text-green-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">No Attendance Records</h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                        There are no attendance records available for this student. Attendance will appear here once recorded.
                    </p>
                </div>
            @endif
        </section>

        <!-- Student Schedule Section -->
<section class="mt-12">
    <div class="flex items-center justify-between mb-6">
        <h2 class="section-title text-2xl font-semibold text-gray-800 dark:text-white">
            Jadwal Les
        </h2>
    </div>

    @if (!empty($schedule) && $schedule['count'] > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Hari
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Jam
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Guru
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Ruang
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($schedule['schedule'] as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($row['date'])->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $row['day'] }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $row['time'] }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-blue-500 dark:text-blue-300">
                                {{ $row['course_alias'] }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $row['teacher'] }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $row['location'] ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 text-center">
            <div class="mx-auto w-24 h-24 bg-blue-50 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-calendar-alt text-3xl text-blue-500 dark:text-blue-300"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-2">
                Tidak Ada Jadwal
            </h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                Jadwal les akan tampil di sini.
            </p>
        </div>
    @endif
</section>

    </main>



    <!-- Footer -->
    <footer class="footer py-4 text-center text-sm mt-12">
        <p>© {{ date('Y') }} Putra Bali English Course. All rights reserved.</p>
    </footer>
</body>
</html>