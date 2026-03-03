@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        {{-- ================= HEADER ================= --}}
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white">Riwayat Mengajar</h2>
            <p class="mt-2 text-lg text-gray-300">
                <span class="font-semibold text-blue-400">
                    {{ $teacher['teacher']['name'] }}
                </span>
            </p>

            {{-- Dynamic Message --}}
            @php
                $firstName = explode(' ', $teacher['teacher']['name'])[0];

                if ($repostCount <= 2) {
                    $message = "Ayo tetap semangat berbagi, $firstName! 💪";
                    $color = "text-yellow-400";
                } elseif ($repostCount == 4) {
                    $message = "Terima kasih atas dedikasi Anda bulan ini 🙏";
                    $color = "text-emerald-400";
                } elseif ($repostCount > 4) {
                    $message = "Luar biasa! Anda melampaui target 🏆";
                    $color = "text-pink-400";
                } else {
                    $message = "Terima kasih atas kontribusi Anda 🙌";
                    $color = "text-blue-400";
                }
            @endphp

            <p class="text-gray-200 text-lg font-medium text-center">
                Anda telah berkontribusi dalam
                <span class="font-extrabold {{ $color }}">
                    ({{ $repostCount }}/4)
                </span>
                Sosial Media PB bulan ini.
            </p>

            <p class="mt-2 text-gray-300 italic text-center">
                {{ $message }}
            </p>

            {{-- Month Picker --}}
            <div class="text-white mt-4 px-4 py-3 bg-gray-800 border border-gray-700 rounded-md">
                <form action="/recap-teacher-absences" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <input type="hidden" name="id" value="{{ $teacher['teacher']['id'] }}">

                    <input 
                        type="month" 
                        name="month" 
                        value="{{ request('month', now()->format('Y-m')) }}"
                        required
                        class="bg-gray-100 text-black dark:bg-gray-700 dark:text-white border rounded-md px-3 py-2 w-full"
                    >

                    <button 
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md"
                    >
                        Cek
                    </button>
                </form>
            </div>
        </div>

        {{-- ================= MEETING HISTORY ================= --}}
        @if ($repostCount < 4)

            <div class="bg-red-900 text-white p-6 rounded-lg text-center shadow-lg">
                Anda harus mengupload minimal <strong>4 repost</strong> untuk membuka riwayat mengajar bulan ini.
            </div>

        @else

        <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-medium text-white">
                    Total:
                    <span class="text-blue-400">
                        Rp {{ number_format($teacher['total_fee'], 0, ',', '.') }}
                    </span>
                </h3>

                <span class="text-white bg-gray-600 px-3 py-1 rounded-full text-sm">
                    {{ $teacher['total_absences'] }} Kelas
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Hari</th>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Waktu</th>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Kelas</th>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Upah</th>
                        </tr>
                    </thead>

                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse ($teacher['teacher']['meetings'] as $meeting)
                            <tr class="hover:bg-gray-700 transition">
                                <td class="px-4 py-4 text-white">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-4 text-gray-300">
                                    {{ \Carbon\Carbon::parse($meeting['date'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-4 py-4 text-gray-300">
                                    {{ $meeting['day'] }}
                                </td>
                                <td class="px-4 py-4 text-gray-300">
                                    {{ $meeting['time'] }}
                                </td>
                                <td class="px-4 py-4 text-blue-400 font-medium">
                                    {{ $meeting['course']['alias'] }}
                                </td>
                                <td class="px-4 py-4 text-blue-400 font-medium">
                                    Rp {{ number_format($meeting['course']['teaching_rate'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                    Tidak ada mengajar pada bulan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @endif


        {{-- ================= REPOST HISTORY ================= --}}
        <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden mt-10">
            <div class="px-4 py-5 sm:px-6 bg-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-medium text-white">
                    📸 Riwayat Repost
                </h3>
                <span class="text-white bg-gray-600 px-3 py-1 rounded-full text-sm">
                    {{ $repostCount }} Repost Bulan Ini
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs text-gray-300 uppercase">Bukti</th>
                        </tr>
                    </thead>

                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse ($proofs as $proof)
                            <tr class="hover:bg-gray-700 transition">
                                <td class="px-4 py-4 text-white">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-4 text-gray-300">
                                    {{ \Carbon\Carbon::parse($proof['uploaded_at'])->locale('id')->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-4 py-4">
                                    <a href="{{ $proof['url'] }}" target="_blank">
                                        <img src="{{ $proof['url'] }}"
                                             class="h-24 rounded-md border border-gray-700 hover:opacity-80 transition">
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-400">
                                    Belum ada repost pada bulan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection