{{-- @dd($course) --}}
@extends('layouts.main')

@section('content')
<div class="p-4 md:p-6 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    <div class="max-w-4xl mx-auto">
      <form method="GET" >
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl md:text-2xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            💰 Harga Tahunan - {{ $course['course_name'] }}
        </h2>

    <select
    onchange="changeYear(this.value)"
    class="text-sm rounded-lg border border-gray-300 dark:border-gray-600
           bg-white dark:bg-gray-800
           text-gray-700 dark:text-gray-200
           px-3 py-1 focus:ring focus:ring-blue-200"
>
    @for ($year = now()->year + 2; $year >= now()->year - 5; $year--)
        <option value="{{ $year }}"
            {{ $course['year'] == $year ? 'selected' : '' }}>
            Tahun {{ $year }}
        </option>
    @endfor
</select>

<script>
function changeYear(year) {
    window.location.href =
        `/course-prices/view/{{ $course['course_id'] }}/${year}`;
}
</script>



    </div>
</form>


        {{-- Flash message --}}
        @if($errors->any())
            <div class="bg-red-100 dark:bg-red-900/40 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-2 rounded mb-4 text-sm">
                {{ implode(', ', $errors->all()) }}
            </div>
        @endif

        {{-- Card utama --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 p-4">
                @foreach ($course['prices'] as $month)
                    <div class="flex flex-col items-start justify-between p-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 bg-gray-50 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <div class="w-full flex justify-between items-center mb-1">
                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::create()->month($month['month'])->translatedFormat('F') }}
                            </span>
                            @if($month['source'] === 'custom')
                                <span class="text-xs bg-blue-100 dark:bg-blue-900/60 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded">Khusus</span>
                            @else
                                <span class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-0.5 rounded">Default</span>
                            @endif
                        </div>

                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Rp{{ number_format($month['price'], 0, ',', '.') }}
                        </div>

                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            {{ $month['note'] ?? '-' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Info tambahan --}}
        <div class="mt-5 text-xs md:text-sm text-gray-600 dark:text-gray-400 text-center">
            <p><strong class="dark:text-gray-200">Default rate:</strong> Rp{{ number_format($course['default_payment_rate'], 0, ',', '.') }}</p>
            <p><strong class="dark:text-gray-200">Keterangan:</strong> Biru = harga khusus dari tabel <code class="text-blue-500 dark:text-blue-400">course_prices</code>.</p>
        </div>
    </div>
</div>
@endsection
