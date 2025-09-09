@extends('layouts.main')

@section('content')
<div class="container mx-auto px-2 sm:px-4 md:px-8 lg:px-16 xl:px-32 mt-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Kategori Keuangan</h1>

    <!-- Form tambah pengeluaran baru -->
    <form id="outcomeForm" method="POST" action="{{ route('finance-entries.store') }}" class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-end flex-wrap" style="display:none;">
        @csrf
        <input type="hidden" name="direction" value="expense">
        <div class="flex-1 min-w-[180px]">
            <label for="outcome_category" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
            <select name="finance_category_id" id="outcome_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    @if ($category['type'] === 'expense')
                        <option value="{{ $category['id'] }}">{{ $category['code'] }} || {{ $category['name'] }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[120px]">
            <label for="outcome_total" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Total</label>
            <input type="number" name="amount" id="outcome_total" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" required>
        </div>
        <div class="flex-1 min-w-[180px]">
            <label for="outcome_note" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Note <span class="text-xs text-gray-400">(opsional)</span></label>
            <input type="text" name="note" id="outcome_note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" placeholder="Catatan tambahan (opsional)">
        </div>
        <button type="submit" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Tambah</button>
    </form>

    <button id="showOutcomeFormBtn" type="button" class="mb-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Tambah Pengeluaran</button>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-900 rounded-lg shadow">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800">
                    <th class="px-4 py-2 text-left dark:text-white">Kode</th>
                    <th class="px-4 py-2 text-left dark:text-white">Nama Kategori</th>
                    <th class="px-4 py-2 text-left dark:text-white">Tipe</th>
                    <th class="px-4 py-2 text-left dark:text-white">Status</th>
                    <th class="px-4 py-2 text-left dark:text-white">Entri Keuangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $cat)
                <tr>
                    <td class="border px-4 py-2 dark:text-white">{{ $cat['code'] }}</td>
                    <td class="border px-4 py-2 dark:text-white">{{ $cat['name'] }}</td>
                    <td class="border px-4 py-2 dark:text-white capitalize">{{ $cat['type'] }}</td>
                    <td class="border px-4 py-2 dark:text-white">{{ $cat['is_active'] ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="border px-4 py-2 dark:text-white">
                        <ul class="list-disc ml-4">
                        @foreach ($cat['finance_entries'] as $entry)
                            <li>
                                <span class="font-semibold">{{ $entry['note'] ?? 'unknown' }}</span> - Rp. {{ number_format($entry['amount'], 0, ',', '.') }} <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($entry['created_at'])->format('d M Y') }})</span>
                            </li>
                        @endforeach
                        @if (empty($cat['finance_entries']))
                            <li class="text-gray-400">Tidak ada entri</li>
                        @endif
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    const outcomeForm = document.getElementById('outcomeForm');
    const showOutcomeFormBtn = document.getElementById('showOutcomeFormBtn');
    if (showOutcomeFormBtn && outcomeForm) {
        showOutcomeFormBtn.addEventListener('click', function() {
            outcomeForm.style.display = 'flex';
            showOutcomeFormBtn.style.display = 'none';
            outcomeForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }
</script>

@endsection
