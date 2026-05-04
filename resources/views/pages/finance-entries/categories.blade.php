@extends('layouts.main')

@section('content')
<div class="container mx-auto px-2 sm:px-4 md:px-8 lg:px-16 xl:px-32 mt-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Daftar Kategori Keuangan</h1>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form tambah pengeluaran baru -->
    <form id="outcomeForm" method="POST" action="{{ route('finance-entries.store') }}" class="mb-8 grid grid-cols-1 gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-900 sm:grid-cols-2 xl:grid-cols-6" style="display:none;">
        @csrf
        <input type="hidden" name="direction" value="expense">
        <div class="xl:col-span-2">
            <label for="outcome_category" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
            <select name="finance_category_id" id="outcome_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    @if ($category['type'] === 'expense')
                        <option value="{{ $category['id'] }}" {{ old('finance_category_id') == $category['id'] ? 'selected' : '' }}>{{ $category['code'] }} || {{ $category['name'] }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="xl:col-span-2">
            <label for="outcome_item_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Barang</label>
            <input type="text" name="item_name" id="outcome_item_name" value="{{ old('item_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" placeholder="Contoh: Pulsa, Bensin, Kertas HVS" required>
        </div>
        <div>
            <label for="outcome_unit_price" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Harga Satuan</label>
            <input type="number" name="unit_price" id="outcome_unit_price" value="{{ old('unit_price') }}" min="0" step="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" placeholder="50000" required>
        </div>
        <div>
            <label for="outcome_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Quantity</label>
            <input type="number" name="quantity" id="outcome_quantity" value="{{ old('quantity', 1) }}" min="1" step="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" required>
        </div>
        <div>
            <label for="outcome_grand_total" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Grand Total</label>
            <input type="text" id="outcome_grand_total" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm dark:bg-gray-700 dark:text-white" readonly>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Dihitung otomatis dari harga satuan x quantity.</p>
        </div>
        <div class="sm:col-span-2 xl:col-span-4">
            <label for="outcome_note" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Note <span class="text-xs text-gray-400">(opsional)</span></label>
            <input type="text" name="note" id="outcome_note" value="{{ old('note') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-800 dark:text-white" placeholder="Catatan tambahan (opsional)">
        </div>
        <div class="sm:col-span-2 xl:col-span-2 flex items-end">
            <button type="submit" class="w-full mt-2 sm:mt-0 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Tambah</button>
        </div>
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
                                <span class="font-semibold">{{ $entry['item_name'] ?? $entry['note'] ?? 'unknown' }}</span> - Rp. {{ number_format($entry['amount'], 0, ',', '.') }} <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($entry['created_at'])->format('d M Y') }})</span>
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
    const unitPriceInput = document.getElementById('outcome_unit_price');
    const quantityInput = document.getElementById('outcome_quantity');
    const grandTotalInput = document.getElementById('outcome_grand_total');

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function updateGrandTotal() {
        if (!unitPriceInput || !quantityInput || !grandTotalInput) return;

        const unitPrice = parseInt(unitPriceInput.value || '0', 10);
        const quantity = parseInt(quantityInput.value || '0', 10);
        const grandTotal = Math.max(unitPrice, 0) * Math.max(quantity, 0);

        grandTotalInput.value = `Rp. ${formatRupiah(grandTotal)}`;
    }

    if (showOutcomeFormBtn && outcomeForm) {
        showOutcomeFormBtn.addEventListener('click', function() {
            outcomeForm.style.display = 'grid';
            showOutcomeFormBtn.style.display = 'none';
            outcomeForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }

    if (unitPriceInput && quantityInput) {
        unitPriceInput.addEventListener('input', updateGrandTotal);
        quantityInput.addEventListener('input', updateGrandTotal);
        updateGrandTotal();
    }

    @if ($errors->any())
        if (outcomeForm && showOutcomeFormBtn) {
            outcomeForm.style.display = 'grid';
            showOutcomeFormBtn.style.display = 'none';
        }
    @endif
</script>

@endsection
