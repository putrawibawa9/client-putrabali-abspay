<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Putra Bali English Course</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>

        
        /* Custom CSS for additional styling */
        .header, .footer {
            background-color: #1a365d;
            color: white;
        }
        .header h1 {
            font-size: 2rem;
            font-weight: bold;
        }
        .footer p {
            font-size: 0.875rem;
        }
        .course-card {
            transition: transform 0.2s ease-in-out;
        }
        .course-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <!-- Header -->
    <header class="header py-6 text-center">
        <h1>Putra Bali English Course</h1>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Payment Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Payment Records</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @if (!empty($payment['course_payments']) && count($payment['course_payments']) > 0)
                    @foreach ($payment['course_payments'] as $row)
                        <div class="course-card bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $row['course']['subject'] }} - {{ $row['course']['alias'] }}
                                </h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Month</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Amount</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($row['payments'] as $r)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $r['type'] }}</td>
                                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $r['payment_month'] }}</td>
                                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">Rp.{{ number_format($r['payment_amount'], 0, ',','.') }}</td>
                                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($r['created_at'])->format('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">No payment records for this course.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-1 lg:col-span-2 text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16"></path>
                        </svg>
                        <p class="text-lg font-semibold text-gray-600 dark:text-gray-400 mt-4">No payment records available</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Absence Section -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Absence Records</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @forelse ($absenceHistory as $absence)
                    <div class="course-card bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                {{ $absence['course']['subject'] }} - {{ $absence['course']['alias'] }}
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Meeting Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Meeting Time</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Absence Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($absence['absences'] as $row)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $row['meeting_date'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $row['meeting_time'] }}</td>
                                            <td class="px-4 py-3">
                                                <button class="py-1 px-4 text-sm font-medium rounded-full {{ $row['status'] === 'present' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                                    {{ $row['status'] }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">No absence records available for this course.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 lg:col-span-2 text-center py-8">
                        <div class="bg-gray-100 dark:bg-gray-700 p-8 rounded-lg shadow">
                            <h2 class="text-2xl font-semibold text-gray-600 dark:text-gray-300">No Absence History Available</h2>
                            <p class="text-gray-500 dark:text-gray-400 mt-4">
                                It seems like there are no records of absences at the moment. 
                                Please check back later or ensure the data is correctly entered.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

 
</body>
</html>