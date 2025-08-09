@extends('layouts.main')

@section('content')
@php
    // Normalisasi data dari controller
    $list  = $payments['payments'] ?? ($payments->payments ?? []);
    $total = $payments['total_payment'] ?? ($payments->total_payment ?? 0);

    $rupiah = fn($n) => 'Rp. ' . number_format((int)$n, 0, ',', '.');
    $indo   = fn($d) => \Carbon\Carbon::parse($d)->locale('id')->translatedFormat('d M Y');
@endphp

<div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-900 dark:border-gray-700">
    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
        Daily Recap — Pembayaran Murid
    </h2>

    {{-- Filter Tanggal --}}
    <form method="GET" action="{{ route('daily-recap-payment.index') }}" class="mb-6">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter By Date Range</label>
        <div class="flex flex-col sm:flex-row gap-2 mb-4">
            <input type="date" name="start_date"
                   value="{{ request('start_date', now()->format('Y-m-d')) }}"
                   class="flex-1 sm:max-w-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                          focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <input type="date" name="end_date"
                   value="{{ request('end_date', now()->format('Y-m-d')) }}"
                   class="flex-1 sm:max-w-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                          focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

            <button type="submit"
                    class="px-4 py-2.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700
                           focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 transition-colors">
                Filter
            </button>
        </div>
    </form>

    {{-- Ringkasan --}}
    <div class="mb-4 flex flex-wrap items-center gap-3">
        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800
                        dark:bg-blue-900 dark:text-blue-300">
            Total Penerimaan: {{ $rupiah($total) }}
        </div>
        @if(count($list) > 0)
            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800
                        dark:bg-blue-900 dark:text-blue-300">
                {{ count($list) }} transaksi
            </div>
        @endif
    </div>

    @if(count($list) > 0)
        {{-- Tabel Desktop --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                <colgroup>
                    <col class="w-[12%]"/>
                    <col class="w-[34%]"/>
                    <col class="w-[20%]"/>
                    <col class="w-[18%]"/>
                    <col class="w-[16%]"/>
                </colgroup>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Siswa</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $p)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">#{{ $p['id'] }}</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-white whitespace-normal break-words">{{ $p['student_name'] }}</td>
                        <td class="px-4 py-3">{{ $p['course_alias'] }}</td>
                        <td class="px-4 py-3">{{ $indo($p['payment_date']) }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">
                            {{ $rupiah($p['payment_amount']) }}
                        </td>
                    </tr>
                    @endforeach
                    {{-- Footer total --}}
                    <tr class="bg-gray-50 dark:bg-gray-800">
                        <td colspan="4" class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Total</td>
                        <td class="px-4 py-3 text-right font-bold text-gray-900 dark:text-white">
                            {{ $rupiah($total) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Kartu Mobile --}}
        <div class="md:hidden space-y-3">
            @foreach($list as $p)
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ $p['student_name'] }}
                    </h4>
                    <span class="text-sm font-semibold text-emerald-700 dark:text-emerald-400">
                        {{ $rupiah($p['payment_amount']) }}
                    </span>
                </div>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-300">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 6a3 3 0 116 0v1h1a3 3 0 013 3v3a3 3 0 01-3 3H5a3 3 0 01-3-3V10a3 3 0 013-3h1V6zm3-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $p['course_alias'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $indo($p['payment_date']) }}</span>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Total di mobile --}}
            <div class="bg-white dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-300">Total</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $rupiah($total) }}</span>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m4-10v10m-8-6h12" />
            </svg>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Tidak ada pembayaran ditemukan</p>
        </div>
    @endif
</div>
@endsection
