<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Payment Details - Putra Bali English Course</title>
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
        .search-form {
            max-width: 600px;
            margin: 0 auto;
        }
        .results-table {
            width: 100%;
            border-collapse: collapse;
        }
        .results-table th, .results-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .results-table th {
            background-color: #f7fafc;
            font-weight: 600;
            color: #4a5568;
        }
        .results-table tbody tr:hover {
            background-color: #f7fafc;
        }
        .no-data {
            text-align: center;
            color: #718096;
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Check Payment Details</h2>
            
            <!-- Search Form -->
            <form id="searchForm" method="GET" action="{{ route('check-status.search') }}" class="search-form">
                <div class="mb-4">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Enter Student's Name:</label>
                    <input type="text" id="search" name="search" required value="{{ request()->get('search') }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Search
                </button>
            </form>

            <!-- Results Section -->
            @isset($students)
                <div class="results mt-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Payment Details</h3>
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Name</th>
                                <th>Check</th>
                            </tr>
                        </thead>
                        <tbody id="resultsBody">
                            @forelse ($students['data'] as $student)
                                <tr>
                                    <td class="text-gray-700 dark:text-gray-300">{{ $student['nis'] }}</td>
                                    <td class="text-gray-700 dark:text-gray-300">{{ $student['name'] }}</td>
                                    <td>
                                        <a href="/public/check-status/{{ $student['id'] }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Check
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="no-data">
                                    <td colspan="3" class="py-4 text-gray-500 dark:text-gray-400">No payment records available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endisset
        </div>
    </main>

    
</body>
</html>