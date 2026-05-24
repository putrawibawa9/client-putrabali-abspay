@extends('layouts.main')

@section('content')
<style>
    .dark .finance-summary-card,
    .dark .finance-filter-panel,
    .dark .finance-category-card,
    .dark .finance-entry-card,
    .dark .finance-empty-state,
    .dark .finance-outcome-form {
        background-color: rgb(17 24 39) !important;
        border-color: rgb(55 65 81) !important;
    }

    .dark .finance-summary-banner {
        background-color: rgba(30, 58, 138, 0.28) !important;
        border-color: rgba(59, 130, 246, 0.35) !important;
        color: rgb(219 234 254) !important;
    }

    .dark .finance-category-header {
        background-color: rgba(31, 41, 55, 0.82) !important;
        border-color: rgb(55 65 81) !important;
    }

    .dark .finance-table thead {
        background-color: rgb(17 24 39) !important;
    }

    .dark .finance-table tbody,
    .dark .finance-table tr,
    .dark .finance-table td,
    .dark .finance-table th {
        border-color: rgb(55 65 81) !important;
    }

    .dark .finance-table tr:hover {
        background-color: rgba(31, 41, 55, 0.5) !important;
    }
</style>

<div class="container mx-auto px-2 sm:px-4 md:px-8 lg:px-16 xl:px-32 mt-8">
    @php
        $expenseCategories = collect($categories)->where('type', 'expense')->values();
        $totalEntries = $expenseCategories->sum(fn ($category) => count($category['finance_entries'] ?? []));
        $structuredEntries = $expenseCategories->sum(function ($category) {
            return collect($category['finance_entries'] ?? [])->filter(function ($entry) {
                return !empty($entry['item_name']) || !empty($entry['unit_price']) || !empty($entry['quantity']);
            })->count();
        });
    @endphp

    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Kategori Keuangan</h1>
            <p class="mt-2 max-w-3xl text-sm text-gray-600 dark:text-gray-300">
                Halaman ini sekarang difokuskan ke detail item pengeluaran. Data backend sudah cukup untuk menampilkan tabel
                `Nama Barang`, `Harga Satuan`, `Quantity`, `Grand Total`, dan `Note`, tetapi beberapa entri lama memang
                masih belum punya `item_name`, `unit_price`, atau `quantity`.
            </p>
        </div>
        <div class="grid grid-cols-2 gap-3 lg:min-w-[360px]">
            <div class="finance-summary-card rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-400">Kategori Expense</div>
                <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $expenseCategories->count() }}</div>
            </div>
            <div class="finance-summary-card rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-400">Total Entri</div>
                <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $totalEntries }}</div>
            </div>
            <div class="finance-summary-banner col-span-2 rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900 shadow-sm dark:border-blue-800/60 dark:bg-blue-950/40 dark:text-blue-100">
                <span class="font-semibold">{{ $structuredEntries }}</span> dari <span class="font-semibold">{{ $totalEntries }}</span> entri sudah punya struktur item modern.
            </div>
        </div>
    </div>

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
    <form id="outcomeForm" method="POST" action="{{ route('finance-entries.store') }}" class="finance-outcome-form mb-8 grid grid-cols-1 gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow dark:border-slate-700 dark:bg-slate-900 sm:grid-cols-2 xl:grid-cols-6" style="display:none;">
        @csrf
        <input type="hidden" name="direction" value="expense">
        <div class="xl:col-span-2">
            <label for="outcome_category" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
            <select name="finance_category_id" id="outcome_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white" required>
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
            <input type="text" name="item_name" id="outcome_item_name" value="{{ old('item_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white" placeholder="Contoh: Pulsa, Bensin, Kertas HVS" required>
        </div>
        <div>
            <label for="outcome_unit_price" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Harga Satuan</label>
            <input type="number" name="unit_price" id="outcome_unit_price" value="{{ old('unit_price') }}" min="0" step="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white" placeholder="50000" required>
        </div>
        <div>
            <label for="outcome_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Quantity</label>
            <input type="number" name="quantity" id="outcome_quantity" value="{{ old('quantity', 1) }}" min="1" step="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white" required>
        </div>
        <div>
            <label for="outcome_grand_total" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Grand Total</label>
            <input type="text" id="outcome_grand_total" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100" readonly>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Dihitung otomatis dari harga satuan x quantity.</p>
        </div>
        <div class="sm:col-span-2 xl:col-span-4">
            <label for="outcome_note" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Note <span class="text-xs text-gray-400">(opsional)</span></label>
            <input type="text" name="note" id="outcome_note" value="{{ old('note') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white" placeholder="Catatan tambahan (opsional)">
        </div>
        <div class="sm:col-span-2 xl:col-span-2 flex items-end">
            <button type="submit" class="w-full mt-2 sm:mt-0 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Tambah</button>
        </div>
    </form>

    <button id="showOutcomeFormBtn" type="button" class="mb-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Tambah Pengeluaran</button>

    <div class="finance-filter-panel mb-6 grid grid-cols-1 gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 md:grid-cols-3">
        <div>
            <label for="categoryFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Filter Kategori</label>
            <select id="categoryFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                <option value="">Semua kategori</option>
                @foreach ($expenseCategories as $category)
                    <option value="{{ strtolower($category['id'] . ' ' . $category['code'] . ' ' . $category['name']) }}">{{ $category['code'] }} - {{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2">
            <label for="expenseSearch" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Search</label>
            <input
                type="text"
                id="expenseSearch"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                placeholder="Cari nama barang, note, kode kategori, atau total..."
            >
        </div>
    </div>

    <div id="emptyFilterState" class="finance-empty-state mb-6 hidden rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-center text-sm text-gray-500 dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-400">
        Tidak ada kategori atau item pengeluaran yang cocok dengan filter saat ini.
    </div>

    <div id="expenseCategoryList" class="space-y-6">
        @foreach ($expenseCategories as $cat)
            @php
                $entries = collect($cat['finance_entries'] ?? [])->sortByDesc('created_at')->values();
                $categoryTotal = $entries->sum(fn ($entry) => (float) ($entry['amount'] ?? 0));
                $categorySearch = strtolower(trim(($cat['code'] ?? '') . ' ' . ($cat['name'] ?? '')));
            @endphp

            <section
                class="expense-category-card finance-category-card overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900"
                data-category-key="{{ strtolower($cat['id'] . ' ' . $cat['code'] . ' ' . $cat['name']) }}"
                data-category-search="{{ $categorySearch }}"
            >
                <div class="finance-category-header border-b border-gray-200 bg-gray-50 px-4 py-4 dark:border-slate-700 dark:bg-slate-800/80 sm:px-6">
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex rounded-full bg-gray-900 px-2.5 py-1 text-xs font-semibold text-white dark:bg-gray-100 dark:text-gray-900">{{ $cat['code'] }}</span>
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $cat['is_active'] ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300' }}">
                                    {{ $cat['is_active'] ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <h2 class="mt-3 text-lg font-semibold text-gray-900 dark:text-white">{{ $cat['name'] }}</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                {{ $entries->count() }} entri pengeluaran • Total Rp {{ number_format($categoryTotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if ($entries->isEmpty())
                    <div class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400 sm:px-6">
                        Belum ada item pengeluaran di kategori ini.
                    </div>
                @else
                    <div class="hidden overflow-x-auto lg:block">
                        <table class="finance-table min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-white dark:bg-slate-900">
                                <tr class="text-left text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-400">
                                    <th class="px-4 py-3 sm:px-6">Nama Barang</th>
                                    <th class="px-4 py-3">Harga Satuan</th>
                                    <th class="px-4 py-3">Quantity</th>
                                    <th class="px-4 py-3">Grand Total</th>
                                    <th class="px-4 py-3">Note</th>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3 text-right sm:px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                @foreach ($entries as $entry)
                                    @php
                                        $entrySearch = strtolower(trim(
                                            ($entry['item_name'] ?? '') . ' ' .
                                            ($entry['note'] ?? '') . ' ' .
                                            ($entry['amount'] ?? '') . ' ' .
                                            ($entry['unit_price'] ?? '') . ' ' .
                                            ($entry['quantity'] ?? '') . ' ' .
                                            ($cat['code'] ?? '') . ' ' .
                                            ($cat['name'] ?? '')
                                        ));
                                    @endphp
                                    <tr class="align-top transition-colors hover:bg-gray-50 dark:hover:bg-slate-800/50">
                                        <td class="entry-row px-4 py-4 text-sm font-medium text-gray-900 dark:text-white sm:px-6" data-entry-search="{{ $entrySearch }}">
                                            {{ $entry['item_name'] ?: '—' }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200">
                                            {{ !is_null($entry['unit_price']) ? 'Rp ' . number_format((float) $entry['unit_price'], 0, ',', '.') : '—' }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200">
                                            {{ !is_null($entry['quantity']) ? number_format((float) $entry['quantity'], 0, ',', '.') : '—' }}
                                        </td>
                                        <td class="px-4 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                            Rp {{ number_format((float) ($entry['amount'] ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $entry['note'] ?: '—' }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($entry['created_at'])->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-4 text-right sm:px-6">
                                            <form method="POST" action="{{ route('finance-entries.destroy', $entry['id']) }}" onsubmit="return confirm('Hapus item pengeluaran ini?');" class="inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-red-200 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-50 dark:border-red-900/40 dark:text-red-300 dark:hover:bg-red-900/20">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="space-y-3 p-4 lg:hidden">
                        @foreach ($entries as $entry)
                            @php
                                $entrySearch = strtolower(trim(
                                    ($entry['item_name'] ?? '') . ' ' .
                                    ($entry['note'] ?? '') . ' ' .
                                    ($entry['amount'] ?? '') . ' ' .
                                    ($entry['unit_price'] ?? '') . ' ' .
                                    ($entry['quantity'] ?? '') . ' ' .
                                    ($cat['code'] ?? '') . ' ' .
                                    ($cat['name'] ?? '')
                                ));
                            @endphp
                            <article class="entry-card finance-entry-card rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-slate-700 dark:bg-slate-800/60" data-entry-search="{{ $entrySearch }}">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $entry['item_name'] ?: '—' }}</h3>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($entry['created_at'])->format('d M Y') }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('finance-entries.destroy', $entry['id']) }}" onsubmit="return confirm('Hapus item pengeluaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-md border border-red-200 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-50 dark:border-red-900/40 dark:text-red-300 dark:hover:bg-red-900/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                <dl class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-[0.08em] text-gray-500 dark:text-gray-400">Harga Satuan</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white">{{ !is_null($entry['unit_price']) ? 'Rp ' . number_format((float) $entry['unit_price'], 0, ',', '.') : '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-[0.08em] text-gray-500 dark:text-gray-400">Quantity</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white">{{ !is_null($entry['quantity']) ? number_format((float) $entry['quantity'], 0, ',', '.') : '—' }}</dd>
                                    </div>
                                    <div class="col-span-2">
                                        <dt class="text-xs font-semibold uppercase tracking-[0.08em] text-gray-500 dark:text-gray-400">Grand Total</dt>
                                        <dd class="mt-1 font-semibold text-gray-900 dark:text-white">Rp {{ number_format((float) ($entry['amount'] ?? 0), 0, ',', '.') }}</dd>
                                    </div>
                                    <div class="col-span-2">
                                        <dt class="text-xs font-semibold uppercase tracking-[0.08em] text-gray-500 dark:text-gray-400">Note</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white">{{ $entry['note'] ?: '—' }}</dd>
                                    </div>
                                </dl>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        @endforeach
    </div>
</div>

<script>
    const outcomeForm = document.getElementById('outcomeForm');
    const showOutcomeFormBtn = document.getElementById('showOutcomeFormBtn');
    const unitPriceInput = document.getElementById('outcome_unit_price');
    const quantityInput = document.getElementById('outcome_quantity');
    const grandTotalInput = document.getElementById('outcome_grand_total');
    const categoryFilter = document.getElementById('categoryFilter');
    const expenseSearch = document.getElementById('expenseSearch');
    const expenseCategoryList = document.getElementById('expenseCategoryList');
    const emptyFilterState = document.getElementById('emptyFilterState');

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function normalizeSearch(value) {
        return (value || '').toString().toLowerCase().trim();
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

    function applyExpenseFilters() {
        if (!expenseCategoryList) return;

        const selectedCategory = normalizeSearch(categoryFilter ? categoryFilter.value : '');
        const searchTerm = normalizeSearch(expenseSearch ? expenseSearch.value : '');
        const cards = expenseCategoryList.querySelectorAll('.expense-category-card');
        let visibleCards = 0;

        cards.forEach((card) => {
            const categoryKey = normalizeSearch(card.dataset.categoryKey);
            const categorySearch = normalizeSearch(card.dataset.categorySearch);
            const matchesCategory = !selectedCategory || categoryKey === selectedCategory;

            const desktopRows = Array.from(card.querySelectorAll('tbody tr'));
            const mobileCards = Array.from(card.querySelectorAll('.entry-card'));
            let visibleEntries = 0;

            desktopRows.forEach((row) => {
                const entryCell = row.querySelector('[data-entry-search]');
                const entrySearch = normalizeSearch(entryCell ? entryCell.dataset.entrySearch : '');
                const matchesSearch = !searchTerm || entrySearch.includes(searchTerm) || categorySearch.includes(searchTerm);
                row.style.display = matchesCategory && matchesSearch ? '' : 'none';
                if (matchesCategory && matchesSearch) visibleEntries += 1;
            });

            mobileCards.forEach((entryCard) => {
                const entrySearch = normalizeSearch(entryCard.dataset.entrySearch);
                const matchesSearch = !searchTerm || entrySearch.includes(searchTerm) || categorySearch.includes(searchTerm);
                entryCard.style.display = matchesCategory && matchesSearch ? '' : 'none';
            });

            const hasVisibleEntry = visibleEntries > 0 || (!searchTerm && matchesCategory && desktopRows.length === 0);
            card.style.display = matchesCategory && hasVisibleEntry ? '' : 'none';

            if (matchesCategory && hasVisibleEntry) {
                visibleCards += 1;
            }
        });

        if (emptyFilterState) {
            emptyFilterState.style.display = visibleCards === 0 ? 'block' : 'none';
        }
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', applyExpenseFilters);
    }

    if (expenseSearch) {
        expenseSearch.addEventListener('input', applyExpenseFilters);
    }

    applyExpenseFilters();

    @if ($errors->any())
        if (outcomeForm && showOutcomeFormBtn) {
            outcomeForm.style.display = 'grid';
            showOutcomeFormBtn.style.display = 'none';
        }
    @endif
</script>

@endsection
