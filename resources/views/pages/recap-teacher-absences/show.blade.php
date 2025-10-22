{{-- @dd($teacher) --}}
@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white">Riwayat Mengajar</h2>
            <p class="mt-2 text-lg text-gray-300"><span class="font-semibold text-blue-400">{{ $teacher['teacher']['name'] }}</span></p>
         @php
    // tentukan pesan dinamis berdasarkan jumlah repost
    if ($repostCount <= 2) {
        $message = "Ayo tetap semangat berbagi, " . explode(' ', $teacher['teacher']['name'])[0] . 
                   "! Setiap repost membantu semakin banyak orang mengenal PB. 💪";
        $color = "text-yellow-400";
    } elseif ($repostCount == 4) {
        $message = "Terima kasih atas dedikasi dan konsistensi Anda bulan ini! 🙏✨";
        $color = "text-emerald-400";
    } elseif ($repostCount > 4) {
        $message = "Wah luar biasa! Anda melampaui target — semangat dan loyalitas Anda patut diapresiasi! 🏆🔥";
        $color = "text-pink-400";
    } else {
        $message = "Terima kasih atas kontribusi Anda! 🙌";
        $color = "text-blue-400";
    }
@endphp

<p class="text-gray-200 text-lg font-medium text-center">
    Anda telah berkontribusi dalam 
    <span class="font-extrabold {{ $color }} drop-shadow-sm">({{ $repostCount }}/4)</span> 
    Sosial Media PB bulan ini.
</p>

<p class="mt-2 text-gray-300 italic text-center">
    {{ $message }}
</p>

            <div class="text-white mt-3 px-4 py-2 bg-gray-800 border border-gray-700 rounded-md font-semibold text-blue-400">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="hidden sm:inline">Pilih Bulan:</span>
                    </div>
                    
                    <form action="/recap-teacher-absences" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
                        <input type="hidden" name="id" value="{{ $teacher['teacher']['id'] }}">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 w-full">
                            <label for="month" class="sm:hidden text-sm">Pilih Bulan:</label>
                            <input 
                                type="month" 
                                name="month" 
                                id="month" 
                                value="{{ request('month', now()->format('Y-m')) }}"
                                required
                                class="bg-gray-100 text-black dark:bg-gray-700 dark:text-white dark:border-gray-600 border rounded-md px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full" 
                            >
                            <button 
                                type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-1.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 w-full sm:w-auto"
                            >
                                Cek
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            
        </div>

        <!-- Absence Card -->
        <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Card Header -->
            <div class="px-4 py-5 sm:px-6 bg-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-lg font-medium text-white">
                     Total:
                        <span class="text-blue-400">Rp. {{ number_format($teacher['total_fee'], 0, ',', '.') }}</span>

                    </h3>
                    <span class=" text-white mt-2 sm:mt-0 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-600 text-blue-300">
                      {{ $teacher['total_absences'] }} Kelas
                    </span>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Hari
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Waktu
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Kelas
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Upah
                            </th>
                        </tr>
                    </thead>
                    @forelse ($teacher['teacher']['meetings'] as $meeting)
                        
                 
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        <tr class="hover:bg-gray-700 transition duration-150">
                              @php
    $days = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu',
    ];
@endphp
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                               {{-- {{ $meeting['date'] }} --}}
                                {{ \Carbon\Carbon::parse($meeting['date'])->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $days[$meeting['day']] ?? $meeting['day'] }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $meeting['time'] }}
                            </td>
                            <td class=" text-white px-4 py-4 whitespace-nowrap text-sm font-medium text-blue-400">
                              {{ $meeting['course']['alias'] }}
                            </td>
                            <td class=" text-white px-4 py-4 whitespace-nowrap text-sm font-medium text-blue-400">
                              {{ $meeting['course']['teaching_rate'] }}
                            </td>
                        </tr>
                    </tbody>
                    @empty
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-400">
                                    Tidak ada mengajar pada bulan ini.
                                </td>
                            </tr>
                        </tbody>
                    @endforelse
                </table>
            </div>
        </div>

      
    </div>
    
</div>
<!-- Repost Proof Table -->
<div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden mt-10">
<!-- Card Header -->
<div class="px-4 py-5 sm:px-6 bg-gray-700 flex justify-between items-center">
    <h3 class="text-lg font-medium text-white">
        📸 Riwayat Repost
    </h3>
    <span class="text-white text-sm bg-gray-600 px-3 py-1 rounded-full">
        {{ $repostCount }} Repost Bulan Ini
    </span>
</div>

<!-- Table Section -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-700">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">#</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Bukti Repost</th>
            </tr>
        </thead>

        @php
            // Pastikan variabel proof berasal dari API
            $proofs = $repostData['proofs'] ?? [];
        @endphp

        @forelse ($proofs as $proof)
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                <tr class="hover:bg-gray-700 transition duration-150">
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-white">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                        {{ $proof['uploaded_at'] ?? '-' }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                        <a href="{{ $proof['url'] }}" target="_blank" class="inline-block">
                            <img src="{{ $proof['url'] }}" 
                                 alt="Repost Proof" 
                                 class="h-24 w-auto rounded-md border border-gray-700 hover:opacity-80 transition">
                        </a>
                    </td>
                </tr>
            </tbody>
        @empty
            <tbody>
                <tr>
                    <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-400">
                        Belum ada repost pada bulan ini.
                    </td>
                </tr>
            </tbody>
        @endforelse
    </table>
</div>
</div>



@endsection