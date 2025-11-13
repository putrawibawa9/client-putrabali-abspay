@extends('layouts.main')

@section('content')
<div class="p-6 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100">
        💰 Pembayaran Tahunan - {{ $course['course_name'] }} ({{ $course['year'] }})
    </h2>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900/40 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 dark:bg-red-900/40 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-2 rounded mb-4">
            {{ implode(', ', $errors->all()) }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transition-colors duration-300">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Bulan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Sumber Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Catatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($course['prices'] as $month)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-100">
                            {{ \Carbon\Carbon::create()->month($month['month'])->translatedFormat('F') }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            Rp{{ number_format($month['price'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($month['source'] === 'custom')
                                <span class="text-blue-600 dark:text-blue-400 font-semibold">Harga Khusus</span>
                            @else
                                <span class="text-gray-400 dark:text-gray-500">Default</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                            <form method="POST" action="{{ route('course-prices.update-month') }}" class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course['course_id'] }}">
                                <input type="hidden" name="year" value="{{ $course['year'] }}">
                                <input type="hidden" name="month" value="{{ $month['month'] }}">

                                <div class="flex items-center gap-2">
                                    <input 
                                        type="number" 
                                        name="payment_amount" 
                                        value="{{ $month['price'] }}" 
                                        class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 rounded p-1 w-24 text-sm text-gray-700 dark:text-gray-200 focus:ring focus:ring-blue-200 dark:focus:ring-blue-500 focus:outline-none">

                                    <input 
                                        type="text" 
                                        name="note" 
                                        value="{{ $month['note'] ?? '' }}" 
                                        placeholder="Catatan..."
                                        class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 rounded p-1 w-44 text-sm text-gray-700 dark:text-gray-200 focus:ring focus:ring-blue-200 dark:focus:ring-blue-500 focus:outline-none">
                                </div>

                                <button type="submit" 
                                    class="px-3 py-1 text-sm bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded transition">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-gray-600 dark:text-gray-400 text-sm">
        <p><strong class="dark:text-gray-200">Default rate:</strong> Rp{{ number_format($course['default_payment_rate'], 0, ',', '.') }}</p>
        <p><strong class="dark:text-gray-200">Keterangan:</strong> Warna biru menandakan harga khusus dari tabel <code class="text-blue-500 dark:text-blue-400">course_prices</code>.</p>
    </div>
</div>
@endsection
