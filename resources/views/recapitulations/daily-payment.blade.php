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
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
       

        <div class="p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Start Date --}}
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-700 dark:text-gray-200">Start Date</label>
                    <input type="date" name="start_date"
                        value="{{ request('start_date', now()->toDateString()) }}"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                {{-- End Date --}}
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-700 dark:text-gray-200">End Date</label>
                    <input type="date" name="end_date"
                        value="{{ request('end_date', now()->toDateString()) }}"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                {{-- Payment Month (ID locale) --}}
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-700 dark:text-gray-200">Payment Month</label>
                    <select name="payment_month"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- All Months --</option>
                        @foreach(range(1,12) as $m)
                            @php
                                $monthName = \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F');
                                $value = strtolower($monthName); // simpan value lowercase biar konsisten dengan request sebelumnya
                            @endphp
                            <option value="{{ $value }}" {{ request('payment_month') == $value ? 'selected' : '' }}>
                                {{ $monthName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Admin/User --}}
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-700 dark:text-gray-200">Admin/User</label>
                    <select name="user_id"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- All Admins --</option>
                        @foreach($users as $user)
                            <option value="{{ $user['id'] }}" {{ request('user_id') == $user['id'] ? 'selected' : '' }}>
                                {{ $user['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Lokasi PB --}}
<div>
    <label class="block mb-1 text-xs font-medium text-gray-700 dark:text-gray-200">
        Lokasi PB
    </label>
    <select name="lokasi_pb"
        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
               focus:ring-blue-500 focus:border-blue-500 p-2.5
               dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">-- Semua Lokasi --</option>
        <option value="1" {{ request('lokasi_pb') == '1' ? 'selected' : '' }}>
            PB 1
        </option>
        <option value="2" {{ request('lokasi_pb') == '2' ? 'selected' : '' }}>
            PB 2
        </option>
    </select>
</div>

<div>
    <label class="block mb-1 text-xs font-medium text-gray-700 dark:text-gray-200">
        Guru
    </label>
    <select name="teacher_id"
        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
               focus:ring-blue-500 focus:border-blue-500 p-2.5
               dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">-- Semua Guru --</option>
          @foreach($teachers['data'] as $teacher)
                            <option value="{{ $teacher['id'] }}" {{ request('teacher_id') == $teacher['id'] ? 'selected' : '' }}>
                                {{ $teacher['name'] }}
                            </option>
                        @endforeach
    </select>
</div>

            </div>

            {{-- Courses (checkbox grid) --}}
            <div class="mt-4">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-200">Courses</label>
                    <label class="inline-flex items-center gap-2 text-xs text-gray-600 dark:text-gray-300">
                        <input id="toggle-all-courses" type="checkbox"
                               class="rounded border-gray-300 dark:border-gray-600"
                               data-target="#courses-checkboxes">
                        <span>Select All</span>
                    </label>
                </div>

                <div id="courses-checkboxes"
                     class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 max-h-44 overflow-auto
                            rounded-lg border border-gray-200 dark:border-gray-700 p-2">
                    {{-- All Courses (kosongkan value untuk semantik lama, atau pakai keyword "all") --}}
                    <label class="inline-flex items-center gap-2 p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="checkbox" name="course_id[]" value=""
                               class="rounded border-gray-300 dark:border-gray-600"
                               {{ is_array(request('course_id')) && in_array('', request('course_id')) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-800 dark:text-gray-100">-- All Courses --</span>
                    </label>

                    @foreach($courses['data'] as $course)
                        @php
                            $checked = (is_array(request('course_id')) && in_array($course['id'], request('course_id')))
                                       || (request('course_id') == $course['id']);
                        @endphp
                        <label for="course-{{ $course['id'] }}"
                               class="inline-flex items-center gap-2 p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                            <input id="course-{{ $course['id'] }}" type="checkbox"
                                   name="course_id[]" value="{{ $course['id'] }}"
                                   class="rounded border-gray-300 dark:border-gray-600"
                                   {{ $checked ? 'checked' : '' }}>
                            <span class="text-sm text-gray-800 dark:text-gray-100">{{ $course['alias'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
             <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Filter</h3>
            <div class="flex items-center gap-2">
                <a href="{{ route('daily-recap-payment.index') }}"
                   class="inline-flex items-center px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600
                          text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Reset
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700
                               focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 transition-colors">
                    Apply
                </button>
            </div>
        </div>
        </div>
    </div>
</form>

{{-- Mini helper: toggle select-all (no build tools needed) --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('#toggle-all-courses');
    const boxWrap = document.querySelector(toggle?.dataset?.target || '');
    if (!toggle || !boxWrap) return;

    toggle.addEventListener('change', () => {
        const boxes = boxWrap.querySelectorAll('input[type="checkbox"][name="course_id[]"]');
        boxes.forEach(cb => { cb.checked = toggle.checked });
    });
});
</script>



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
             
                        <th class="px-4 py-3">Print</th>
                        <th class="px-4 py-3">Siswa</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3">Bulan</th>
                        <th class="px-4 py-3 ">Jumlah</th>
                        <th class="px-4 py-3 text-right">Admin</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach($list as $p)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750">
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
    <a href="{{ route('payments.receipt', $p['id']) }}" 
       target="_blank"
       class="inline-flex items-center px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h12a2 2 0 002-2V9a2 2 0 00-2-2H6a2 2 0 00-2 2v3a2 2 0 002 2z" />
        </svg>
        Print
    </a>
</td>


                        <td class="px-4 py-3 text-primary-600 hover:underline dark:text-primary-400">
                            <a href="{{ route('students.show', $p['student_id']) }}">
                                {{ $p['student_name'] }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-primary-600 hover:underline dark:text-primary-400">
                            <a href="{{ route('courses.students', $p['course_id']) }}">

                                {{ $p['course_alias'] }}
                            </a>
                        </td>
                        <td class="px-4 py-3">{{ $indo($p['payment_date']) }}</td>
                        <td class="px-4 py-3">{{ $p['type'] }}</td>
                      <td class="px-4 py-3">
    @php
        $bulanInggris = [
            'january' => 'Januari',
            'february' => 'Februari',
            'march' => 'Maret',
            'april' => 'April',
            'may' => 'Mei',
            'june' => 'Juni',
            'july' => 'Juli',
            'august' => 'Agustus',
            'september' => 'September',
            'october' => 'Oktober',
            'november' => 'November',
            'december' => 'Desember',
        ];

        $bulan = $p['payment_month'];
        echo $bulanInggris[$bulan] ?? $bulan; // fallback kalau ada data aneh
    @endphp
</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">
                            {{ $rupiah($p['payment_amount']) }}
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">
                            {{ $p['admin_name'] ?? 'N/A' }}
                        </td>
                    </tr>
                    @endforeach
                    {{-- Footer total --}}
                    <tr class="bg-gray-50 dark:bg-gray-800">
                        <td colspan="7" class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Total</td>
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
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 6a3 3 0 116 0v1h1a3 3 0 013 3v3a3 3 0 01-3 3H5a3 3 0 01-3-3V10a3 3 0 013-3h1V6zm3-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $p['payment_month'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 6a3 3 0 116 0v1h1a3 3 0 013 3v3a3 3 0 01-3 3H5a3 3 0 01-3-3V10a3 3 0 013-3h1V6zm3-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $p['type'] }}</span>
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
