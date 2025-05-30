<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Check | Putra Bali English Course</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a365d;
            --secondary: #2c5282;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .search-card {
            background: linear-gradient(to bottom right, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .dark .search-card {
            background: linear-gradient(to bottom right, #1e293b 0%, #0f172a 100%);
        }
        .search-input {
            transition: all 0.3s ease;
            padding-left: 2.5rem;
        }
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
        .search-icon {
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }
        .results-table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .results-table th {
            position: sticky;
            top: 0;
            background-color: #f8fafc;
        }
        .dark .results-table th {
            background-color: #1e293b;
        }
        .results-table tr:last-child td {
            border-bottom: none;
        }
        .check-btn {
            transition: all 0.2s ease;
        }
        .check-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <header class="header py-6 text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full transform -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full transform translate-x-1/4 translate-y-1/4"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-graduation-cap mr-2"></i>Putra Bali English Course
            </h1>
            <p class="text-blue-100">Sistem Absensi dan Pembayaran </p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Search Card -->
        <div class="search-card p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                <span class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg mr-4">
                    <i class="fas fa-search-dollar text-blue-600 dark:text-blue-300"></i>
                </span>
                Cek Data Pembayaran dan Absensi Siswa
            </h2>
            
            <!-- Search Form -->
            <form id="searchForm" method="GET" action="{{ route('check-status.search') }}" class="space-y-4">
                <div class="relative">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Cari Siswa 
                    </label>
                    <div class="relative">
                        <div class="absolute search-icon text-gray-400 dark:text-gray-500">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <input type="text" id="search" name="search" required value="{{ request()->get('search') }}"
                               class="search-input block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 dark:text-white"
                               placeholder="Enter student name or NIS">
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                      Cari siswa berdasarkan nama atau NIS.
                    </p>
                </div>
                <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all pulse">
                    <i class="fas fa-search mr-2"></i>Cari Siswa
                </button>
            </form>
        </div>

        <!-- Results Section -->
        @isset($students)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                    <i class="fas fa-list-check mr-2 text-blue-500"></i> Hasil Pencarian
                </h3>
                <span class="text-sm px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">
                    {{ count($students['data']) }} data ditemukan   
                </span>
            </div>
            
            @if(count($students['data']) > 0)
            <div class="overflow-x-auto">
                <table class="results-table min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-user mr-1"></i> Nama 
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-id-card mr-1"></i> NIS
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($students['data'] as $student)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/public/check-status/{{ $student['id'] }}" 
                                   class="check-btn inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-file-invoice-dollar mr-2"></i> Lihat Status
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $student['name'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $student['nis'] }}
                            </td>
                          
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-file-search text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white">No Payment Records Found</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    We couldn't find any payment records matching your search.
                </p>
                <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">
                    Try searching with different terms or check the spelling.
                </p>
            </div>
            @endif
        </div>
        @endisset
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-300 text-sm">
                <i class="fas fa-lock mr-1"></i> Secure Payment Verification System
            </p>
            <p class="text-gray-400 text-xs mt-2">
                © {{ date('Y') }} Putra Bali English Course. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        // Add animation to search button on page load
        document.addEventListener('DOMContentLoaded', function() {
            const searchBtn = document.querySelector('.pulse');
            setTimeout(() => {
                searchBtn.classList.remove('pulse');
            }, 4000);
        });
    </script>
</body>
</html>