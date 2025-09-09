
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
    <!-- Analisis Bisnis -->
    @php
        $grandTotalIncome = 0;
        $grandTotalOutcome = 0;
        $incomeCount = 0;
        $outcomeCount = 0;
        $topIncome = null;
        $topOutcome = null;
        $maxIncome = 0;
        $maxOutcome = 0;
        $incomeCategories = $financeCategory['income_category'] ?? [];
        $outcomeCategories = $financeCategory['outcome_category'] ?? [];
        foreach ($incomeCategories as $row) {
            $grandTotalIncome += $row['total_amount'];
            $incomeCount++;
            if ($row['total_amount'] > $maxIncome) {
                $maxIncome = $row['total_amount'];
                $topIncome = $row['category'];
            }
        }
        foreach ($outcomeCategories as $row) {
            $grandTotalOutcome += $row['total_amount'];
            $outcomeCount++;
            if ($row['total_amount'] > $maxOutcome) {
                $maxOutcome = $row['total_amount'];
                $topOutcome = $row['category'];
            }
        }
        $labaBersih = $grandTotalIncome - $grandTotalOutcome;
        $profitMargin = $grandTotalIncome > 0 ? ($labaBersih / $grandTotalIncome) * 100 : 0;
        $avgIncome = $incomeCount > 0 ? $grandTotalIncome / $incomeCount : 0;
        $avgOutcome = $outcomeCount > 0 ? $grandTotalOutcome / $outcomeCount : 0;
        $ratio = $grandTotalOutcome > 0 ? $grandTotalIncome / $grandTotalOutcome : 0;
        $saldoAwal = 0; // Jika ada saldo awal, bisa diganti
        $sisaKas = $saldoAwal + $grandTotalIncome - $grandTotalOutcome;
    @endphp
    <div class="w-full max-w-3xl mx-auto mt-8 mb-8">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
            <div class="text-xl font-bold text-gray-900 dark:text-white mb-4 text-center">Analisis Bisnis</div>
            <table class="w-full text-base">
                <tbody>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Laba Bersih</td>
                        <td class="py-2 text-3xl font-bold text-green-700 dark:text-green-300 dark:text-white">Rp. {{ number_format($labaBersih, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Profit Margin</td>
                        <td class="py-2 dark:text-white">{{ number_format($profitMargin, 2) }}%</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Rata-rata Pemasukan</td>
                        <td class="py-2 dark:text-white">Rp. {{ number_format($avgIncome, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Rata-rata Pengeluaran</td>
                        <td class="py-2 dark:text-white">Rp. {{ number_format($avgOutcome, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Kategori Pemasukan Terbesar</td>
                        <td class="py-2 dark:text-white">{{ $topIncome ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Kategori Pengeluaran Terbesar</td>
                        <td class="py-2 dark:text-white">{{ $topOutcome ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Rasio Pemasukan : Pengeluaran</td>
                        <td class="py-2 dark:text-white">{{ $grandTotalOutcome > 0 ? number_format($ratio, 2) : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Jumlah Transaksi Pemasukan</td>
                        <td class="py-2 dark:text-white">{{ $incomeCount }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Jumlah Transaksi Pengeluaran</td>
                        <td class="py-2 dark:text-white">{{ $outcomeCount }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold dark:text-white">Sisa Kas</td>
                        <td class="py-2 dark:text-white">Rp. {{ number_format($sisaKas, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8 mb-6">
        {{-- @dd($financeCategory) --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Pemasukan</h3>
            <!-- Form tambah pemasukan baru -->
          
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800">
                        <th class="border px-4 py-2 text-left dark:text-white">Kategori</th>
                        <th class="border px-4 py-2 text-left dark:text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotalIncome = 0;
                    @endphp
                    @foreach ($financeCategory['income_category'] as $row)
                        @php
                            $grandTotalIncome += $row['total_amount'];
                        @endphp
                        <tr>
                            <td class="border px-4 py-2 dark:text-white">{{ $row['code'] }} || {{ $row['category'] }}</td>
                            <td class="border px-4 py-2 dark:text-white">
                                Rp. {{ number_format($row['total_amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-green-100 dark:bg-green-900 font-bold">
                        <td class="border px-4 py-2 dark:text-white text-right">Grand Total</td>
                        <td class="border px-4 py-2 dark:text-white">Rp. {{ number_format($grandTotalIncome, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Pengeluaran</h3>
            <!-- Tombol tampilkan form pengeluaran -->
        
            <!-- Form tambah pengeluaran baru -->
       
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800">
                        <th class="border px-4 py-2 text-left dark:text-white">Kategori</th>
                        <th class="border px-4 py-2 text-left dark:text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotalOutcome = 0;
                    @endphp
                    @foreach ($financeCategory['outcome_category'] as $row)
                        @php
                            $grandTotalOutcome += $row['total_amount'];
                        @endphp
                        <tr>
                            <td class="border px-4 py-2 dark:text-white">{{ $row['code'] }} || {{ $row['category'] }}</td>
                            <td class="border px-4 py-2 dark:text-white">
                                Rp. {{ number_format($row['total_amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-red-100 dark:bg-red-200 font-bold">
                        <td class="border px-4 py-2 dark:text-white text-right  bg-red-600">Grand Total</td>
                        <td class="border px-4 py-2 dark:text-white  bg-red-600" >Rp. {{ number_format($grandTotalOutcome, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Laba Bersih -->
    <div class="flex justify-center my-8">
        @php
            $grandTotalIncome = isset($grandTotalIncome) ? $grandTotalIncome : 0;
            $grandTotalOutcome = isset($grandTotalOutcome) ? $grandTotalOutcome : 0;
            $labaBersih = $grandTotalIncome - $grandTotalOutcome;
        @endphp
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 w-full max-w-md text-center">
            <div class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Laba Bersih</div>
            <div class="text-2xl font-bold text-green-700 dark:text-green-300">
                Rp. {{ number_format($labaBersih, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>



<script>
    const outcomeForm = document.getElementById('outcomeForm');
    const showOutcomeFormBtn = document.getElementById('showOutcomeFormBtn');
    
    // Check if elements exist before trying to use them
    if (showOutcomeFormBtn && outcomeForm) {
        // Tampilkan form pengeluaran saat tombol diklik
        showOutcomeFormBtn.addEventListener('click', function() {
            outcomeForm.style.display = 'flex';
            showOutcomeFormBtn.style.display = 'none';
            outcomeForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }

    // Only run the form interaction code if incomeForm exists
    const incomeForm = document.getElementById('incomeForm');
    
    if (incomeForm && outcomeForm) {
        const incomeFields = incomeForm.querySelectorAll('input, select, textarea');
        const incomeSubmit = incomeForm.querySelector('button[type="submit"]');
        const outcomeFields = outcomeForm.querySelectorAll('input, select, textarea');
        const outcomeSubmit = outcomeForm.querySelector('button[type="submit"]');

        function setFormState(fields, submitBtn, disabled) {
            fields.forEach(input => {
                if (input.type !== 'hidden') {
                    if (disabled) {
                        input.setAttribute('disabled', 'disabled');
                    } else {
                        input.removeAttribute('disabled');
                    }
                }
            });
            if (submitBtn) {
                if (disabled) {
                    submitBtn.setAttribute('disabled', 'disabled');
                } else {
                    submitBtn.removeAttribute('disabled');
                }
            }
        }

        incomeForm.addEventListener('focusin', function() {
            setFormState(outcomeFields, outcomeSubmit, true);
            setFormState(incomeFields, incomeSubmit, false);
        });

        outcomeForm.addEventListener('focusin', function() {
            setFormState(incomeFields, incomeSubmit, true);
            setFormState(outcomeFields, outcomeSubmit, false);
        });

        document.addEventListener('mousedown', function(e) {
            if (!incomeForm.contains(e.target) && !outcomeForm.contains(e.target)) {
                setFormState(incomeFields, incomeSubmit, false);
                setFormState(outcomeFields, outcomeSubmit, false);
            }
        });
    } else if (outcomeForm) {
        // If only outcomeForm exists, just handle the outcome form interactions
        const outcomeFields = outcomeForm.querySelectorAll('input, select, textarea');
        const outcomeSubmit = outcomeForm.querySelector('button[type="submit"]');

        outcomeForm.addEventListener('focusin', function() {
            // Enable outcome form fields when focused
            outcomeFields.forEach(input => {
                if (input.type !== 'hidden') {
                    input.removeAttribute('disabled');
                }
            });
            if (outcomeSubmit) {
                outcomeSubmit.removeAttribute('disabled');
            }
        });
    }
</script>


@endsection