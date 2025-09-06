
@extends('layouts.main')

@section('content')
<div class="container mx-auto px-2 sm:px-4 md:px-8 lg:px-16 xl:px-32">
    <!-- Filter tanggal -->
    <form method="GET" class="flex flex-col sm:flex-row gap-2 sm:items-end mt-8 mb-4 bg-white dark:bg-gray-900 rounded-lg shadow p-4">
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white">
        </div>
        <button type="submit" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Filter</button>
    </form>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8 mb-6">
        {{-- @dd($financeCategory) --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Pemasukan</h3>
            <!-- Form tambah pemasukan baru -->
            <form method="POST" class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end">
                @csrf
                <div class="flex-1">
                    <label for="income_category" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                    <input type="text" name="category" id="income_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" required>
                </div>
                <div class="flex-1">
                    <label for="income_total" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Total</label>
                    <input type="number" name="total_amount" id="income_total" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" required>
                </div>
                <button type="submit" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Tambah</button>
            </form>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800">
                        <th class="border px-4 py-2 text-left dark:text-white">Kategori</th>
                        <th class="border px-4 py-2 text-left dark:text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                    @endphp
                    @foreach ($financeCategory['income_category'] as $row)
                        @php
                            $grandTotal += $row['total_amount'];
                        @endphp
                        <tr>
                            <td class="border px-4 py-2 dark:text-white">{{ $row['category'] }}</td>
                            <td class="border px-4 py-2 dark:text-white">
                                Rp. {{ number_format($row['total_amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Pengeluaran</h3>
            <!-- Form tambah pengeluaran baru -->
            <form method="POST" class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end">
                @csrf
                <div class="flex-1">
                    <label for="outcome_category" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                    <input type="text" name="category" id="outcome_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" required>
                </div>
                <div class="flex-1">
                    <label for="outcome_total" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Total</label>
                    <input type="number" name="total_amount" id="outcome_total" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" required>
                </div>
                <button type="submit" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Tambah</button>
            </form>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800">
                        <th class="border px-4 py-2 text-left dark:text-white">Kategori</th>
                        <th class="border px-4 py-2 text-left dark:text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                    @endphp
                    @foreach ($financeCategory['outcome_category'] as $row)
                        @php
                            $grandTotal += $row['total_amount'];
                        @endphp
                        <tr>
                            <td class="border px-4 py-2 dark:text-white">{{ $row['category'] }}</td>
                            <td class="border px-4 py-2 dark:text-white">
                                Rp. {{ number_format($row['total_amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection