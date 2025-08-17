{{-- @dd($student) --}}
@extends('layouts.main')

@section('content')
@php
  $active = $student['active_courses'] ?? [];
@endphp

<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-4 space-y-8">

  {{-- Breadcrumb --}}
  <nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
      <li class="inline-flex items-center">
        <a href="#"
           class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
          <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
          </svg>
          Home
        </a>
      </li>
      <li>
        <div class="flex items-center">
          <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
          </svg>
          <a href="/payments" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">
            Payments
          </a>
        </div>
      </li>
      <li>
        <div class="flex items-center">
          <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
          </svg>
          <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Create Payment</span>
        </div>
      </li>
    </ol>
  </nav>

  {{-- Header card --}}
  <div class="bg-gray-100 dark:bg-gray-800 w-full p-4 sm:p-6 lg:p-8 rounded border border-gray-200 dark:border-gray-700">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div class="flex items-start gap-4 md:gap-6">
        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gray-200 dark:bg-gray-700 shrink-0"></div>
        <div>
          <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white break-words">
            {{ $student['name'] }}
          </h1>
          @if(count($active) > 0)
            <ul class="mt-3 flex flex-wrap gap-x-4 gap-y-2">
              @foreach ($active as $course)
                <li class="text-gray-700 dark:text-gray-300 inline-flex items-center gap-2">
                  <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-800 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="text-sm sm:text-base">{{ $course['subject'] }} - {{ $course['alias'] }}</span>
                </li>
              @endforeach
            </ul>
          @else
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Tidak ada course aktif.</p>
          @endif
        </div>
      </div>

      <div class="w-full md:w-auto">
        <a href="{{ route('students.show', $student['id']) }}"
           class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.293 15.707a1 1 0 0 1 0-1.414L13.586 11H3a1 1 0 1 1 0-2h10.586l-3.293-3.293a1 1 0 1 1 1.414-1.414l5 5a1 1 0 0 1 0 1.414l-5 5a1 1 0 0 1-1.414 0Z"/>
          </svg>
          <span>Lihat Detail</span>
        </a>
      </div>
    </div>
  </div>
  {{-- check user id --}}
 

  {{-- Create Payment Form --}}
  <form action="{{ route('payments.store') }}" method="POST" onsubmit="return confirm('Apakah pembayaran sudah benar?');">
    @csrf
    <input type="hidden" name="student_id" value="{{ $student['id'] }}">
    <input type="hidden" name="actor" value="{{ session('actor') }}">
    {{-- Hidden User ID --}}
    <input type="hidden" name="user_id" value="{{ session('user')['id']}}">
    <div class="min-h-full">
      @if(count($active) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 lg:gap-10 mt-4">
          @foreach ($active as $index => $course)
            <div class="p-4 sm:p-6 lg:p-8 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 dark:bg-[#111827] dark:border-gray-700 dark:hover:bg-gray-700">
              <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900 dark:text-white break-words">
                {{ $course['subject'] }} - {{ $course['alias'] }}
              </h3>

              {{-- Hidden Course ID --}}
              <input type="hidden" name="courses[{{ $index }}][course_id]" value="{{ $course['id'] }}">

              <div class="mt-5">
                <label for="tanggal_{{ $index }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                <input value="{{ now()->format('Y-m-d') }}" type="date" id="tanggal_{{ $index }}" name="courses[{{ $index }}][payment_date]"
                       class="w-full bg-gray-50 border py-3 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white [&::-webkit-calendar-picker-indicator]:dark:filter [&::-webkit-calendar-picker-indicator]:dark:invert" />
              </div>

              <div class="mt-5">
                <label for="tipe_{{ $index }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                <select id="tipe_{{ $index }}" name="courses[{{ $index }}][type]"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                  <option value="" selected>Select Type</option>
                  <option value="spp">Pembayaran SPP</option>
                  <option value="modul">Modul || Rp.50.000</option>
                  <option value="pendaftaran">Pendaftaran || Rp.50.000</option>
                  <option value="ujian">Ujian || Rp.50.000</option>
                </select>
              </div>

              <div class="mt-5">
                <label for="bulan_{{ $index }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Month</label>
                <select id="bulan_{{ $index }}" name="courses[{{ $index }}][payment_month]"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                  <option value="" selected>Select Month</option>
                  <option value="january">January</option>
                  <option value="february">February</option>
                  <option value="march">March</option>
                  <option value="april">April</option>
                  <option value="may">May</option>
                  <option value="june">June</option>
                  <option value="july">July</option>
                  <option value="august">August</option>
                  <option value="september">September</option>
                  <option value="october">October</option>
                  <option value="november">November</option>
                  <option value="december">December</option>
                </select>
              </div>

              <div class="mt-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Payment Amount</label>

                <div class="flex flex-col gap-4 mt-3 md:flex-row md:gap-6">
                  {{-- Normal Course Rate (display only) --}}
                  <div class="flex items-start gap-2">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-300">
                      <div class="flex flex-col">
                        <span>Harga Normal Kursus</span>
                        <span>Rp. {{ number_format((int)($course['payment_rate'] ?? 0), 0, ',', '.') }}</span>
                      </div>
                    </div>
                  </div>

                  {{-- Discounted (display only) --}}
                  @php $customRate = (int)($course['pivot']['custom_payment_rate'] ?? 0); @endphp
                  <div class="flex items-start gap-2">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-300">
                      <div class="flex flex-col">
                        <span>Harga Setelah Potongan</span>
                        <span>{{ $customRate > 0 ? 'Rp. '.number_format($customRate, 0, ',', '.') : '—' }}</span>
                      </div>
                    </div>
                  </div>

                  {{-- Manual Payment Input --}}
                  <div class="flex flex-col gap-1 w-full md:w-56">
                    <label class="text-sm text-gray-700 dark:text-gray-300">Input jumlah manual</label>
                    <input required type="number" name="courses[{{ $index }}][payment_amount]" placeholder="Masukkan jumlah"
                           class="w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        {{-- Empty state bila tidak ada course --}}
        <div class="mt-4 p-6 rounded-lg border border-amber-200 bg-amber-50 dark:bg-amber-900/20 dark:border-amber-800">
          <div class="text-gray-700 dark:text-amber-200 font-medium">
            Siswa ini belum terdaftar di course aktif mana pun.
          </div>
          <div class="mt-2 text-sm text-gray-600 dark:text-amber-300">
            Tambahkan course terlebih dahulu sebelum membuat pembayaran.
          </div>
          <div class="mt-4">
            <a href="{{ route('students.show', $student['id']) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded">
              Kelola Course Siswa
            </a>
          </div>
        </div>
      @endif
    </div>

    {{-- Submit --}}
    <div class="flex justify-end">
      <button type="submit"
        @if(count($active) === 0)
          disabled aria-disabled="true"
          class="opacity-50 cursor-not-allowed inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-2 text-sm font-semibold text-white bg-primary-700 rounded-md"
        @else
          class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-2 text-sm font-semibold text-white bg-primary-700 rounded-md hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition dark:focus:ring-offset-gray-800"
        @endif>
        <svg class="w-5 h-5 sm:w-6 sm:h-6" aria-hidden="true" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z"/>
        </svg>
        <span>Save</span>
      </button>
    </div>
  </form>

  {{-- Riwayat Pembayaran --}}
  <section class="space-y-4">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
      <h2 class="text-lg sm:text-2xl font-semibold text-gray-900 dark:text-white">Riwayat Pembayaran</h2>
      <div class="w-full sm:w-auto">
        <a target="_blank" href="{{ route('formPembayaran.print', $student['id']) }}"
           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-primary-700 hover:bg-primary-800 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
          <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
          </svg>
          <span>Print Kartu Pembayaran</span>
        </a>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
      @if (!empty($payment['course_payments']) && count($payment['course_payments']) > 0)
        @foreach ($payment['course_payments'] as $row)
          <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="px-4 sm:px-6 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
              <h3 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-gray-200">
                {{ $row['course']['subject'] }} - {{ $row['course']['alias'] }}
              </h3>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th class="px-4 sm:px-6 py-3">Type</th>
                    <th class="px-4 sm:px-6 py-3">Month</th>
                    <th class="px-4 sm:px-6 py-3">Amount</th>
                    <th class="px-4 sm:px-6 py-3">Date</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                  @forelse ($row['payments'] as $r)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                       <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
    <a href="{{ route('payments.receipt', $r['id']) }}" 
       target="_blank"
       class="inline-flex items-center px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h12a2 2 0 002-2V9a2 2 0 00-2-2H6a2 2 0 00-2 2v3a2 2 0 002 2z" />
        </svg>
        Print
    </a>
</td>
                      <td class="px-4 sm:px-6 py-3 text-gray-900 dark:text-white whitespace-nowrap">
                        {{ $r['type'] }}
                      </td>
                      <td class="px-4 sm:px-6 py-3 text-gray-900 dark:text-white whitespace-nowrap">
                        {{ $r['payment_month'] }}
                      </td>
                      <td class="px-4 sm:px-6 py-3 text-gray-900 dark:text-white whitespace-nowrap">
                        Rp.{{ number_format($r['payment_amount'], 0, ',','.') }}
                      </td>
                      <td class="px-4 sm:px-6 py-3 text-gray-900 dark:text-white whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($r['created_at'])->format('d M Y') }}
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="px-4 sm:px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        No payment records for this course.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-span-1 lg:col-span-2 text-center py-10">
          <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m4-10v10m-8-6h12"/>
          </svg>
          <p class="mt-3 text-gray-600 dark:text-gray-400">No payment records available</p>
        </div>
      @endif
    </div>
  </section>
</div>

{{-- Scripts (kept as-is; layout-only changes) --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const courseCount = {{ count($active) }};
    if (courseCount === 0) return;

    const paymentForm = document.querySelector('form');

    for (let i = 0; i < courseCount; i++) {
      const typeSelect  = document.getElementById(`tipe_${i}`);
      const monthSelect = document.getElementById(`bulan_${i}`);

      const checkboxes  = document.querySelectorAll(`input[name="courses[${i}][payment_amount]"][type="checkbox"]`);
      const manualInput = document.querySelector(`input[name="courses[${i}][payment_amount]"][type="number"]`);

      const toggleFields = () => {
        const isSPP = typeSelect && typeSelect.value === 'spp';

        if (monthSelect) {
          monthSelect.disabled = !isSPP;
          monthSelect.classList.toggle('opacity-50', !isSPP);
          monthSelect.classList.toggle('cursor-not-allowed', !isSPP);
          if (!isSPP) monthSelect.value = '';
        }

        checkboxes.forEach(cb => {
          cb.disabled = !isSPP;
          if (!isSPP) cb.checked = false;
          cb.classList.toggle('opacity-50', !isSPP);
          cb.classList.toggle('cursor-not-allowed', !isSPP);
        });

        if (manualInput) {
          manualInput.disabled = !isSPP;
          if (!isSPP) manualInput.value = '';
          manualInput.classList.toggle('opacity-50', !isSPP);
          manualInput.classList.toggle('cursor-not-allowed', !isSPP);
        }
      };

      const handlePaymentSelection = (event) => {
        if (!event) return;

        if (event.target && event.target.type === 'checkbox') {
          checkboxes.forEach(cb => { if (cb !== event.target) cb.checked = false; });
          if (manualInput) manualInput.value = '';
        }
        else if (event.target === manualInput) {
          if (manualInput.value !== '') {
            checkboxes.forEach(cb => cb.checked = false);
          }
        }
      };

      if (typeSelect) typeSelect.addEventListener('change', toggleFields);
      checkboxes.forEach(cb => cb.addEventListener('change', handlePaymentSelection));
      if (manualInput) {
        manualInput.addEventListener('input', handlePaymentSelection);
        manualInput.addEventListener('change', handlePaymentSelection);
      }

      toggleFields();
    }

    paymentForm.addEventListener('submit', function () {
      for (let j = 0; j < courseCount; j++) {
        const cbList      = document.querySelectorAll(`input[name="courses[${j}][payment_amount]"][type="checkbox"]`);
        const manualInput = document.querySelector(`input[name="courses[${j}][payment_amount]"][type="number"]`);

        const anyChecked = Array.from(cbList).some(cb => cb.checked);
        const hasManual  = manualInput && manualInput.value !== '';

        if (hasManual) {
          cbList.forEach(cb => cb.removeAttribute('name'));
        } else if (anyChecked && manualInput) {
          manualInput.removeAttribute('name');
        }
      }
    });
  });
</script>
@endsection
