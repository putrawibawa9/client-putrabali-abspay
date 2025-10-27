@extends('layouts.main')

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <!-- Breadcrumb -->
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="/"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span
                                    class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">
                                    Unpaid Students
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    Murid Belum Bayar 2 Bulan
                </h1>

                <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    <p>
                        <strong>Bulan:</strong>
                        {{ ucfirst($months[0] ?? '-') }} & {{ ucfirst($months[1] ?? '-') }} {{ $year ?? date('Y') }}
                    </p>
                    <p><strong>Total:</strong> {{ $count ?? 0 }} murid</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="flex flex-1 flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    #
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    NIS
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Nama
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Nomor WA
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($students as $index => $student)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-gray-900 dark:text-white">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="p-4 text-gray-900 dark:text-white">
                                        {{ $student['nis'] }}
                                    </td>
                                    
                                    <td class="p-4 text-gray-900 dark:text-white">
                                        <a href="/students/{{ $student['id'] }}" class="text-primary-600 hover:underline">{{ $student['name'] }}</a>
                                    </td>
                                    <td class="p-4 text-gray-900 dark:text-white">
                                        @if(!empty($student['wa_number']))
                                            @php
                                                // remove non-digit characters
                                                $raw = preg_replace('/\D+/', '', $student['wa_number']);
                                                // convert leading 0 to country code 62 (Indonesia)
                                                if (substr($raw, 0, 1) === '0') {
                                                    $phone = '62' . substr($raw, 1);
                                                } else {
                                                    $phone = $raw;
                                                }
                                            @endphp
                                            <a href="https://wa.me/{{ $phone }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-green-600 hover:underline">
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M20.52 3.48A11.92 11.92 0 0012 0C5.373 0 .01 5.373 0 12c0 2.11.548 4.176 1.587 6.014L0 24l6.224-1.614A11.933 11.933 0 0012 24c6.627 0 12-5.373 12-12 0-3.206-1.248-6.217-3.48-8.52zM12 22.08c-1.86 0-3.69-.5-5.279-1.44l-.377-.22-3.694.96.987-3.6-.245-.374A9.06 9.06 0 012.94 12 9.06 9.06 0 0112 2.94 9.06 9.06 0 0121.06 12 9.06 9.06 0 0112 22.08z"/>
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.473-.148-.673.149-.198.297-.767.967-.94 1.164-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.884-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.133-.132.297-.347.445-.52.149-.173.198-.298.298-.497.099-.198.05-.372-.025-.52-.075-.148-.673-1.62-.922-2.218-.242-.582-.487-.503-.673-.513l-.575-.01c-.198 0-.52.074-.793.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487 1.263.545 2.25.87 3.024 1.112 1.27.403 2.43.347 3.345.211.102-.051 1.758-.718 2.006-1.412.248-.695.248-1.29.173-1.412-.074-.124-.273-.198-.57-.347z"/>
                                                </svg>
                                                <span class="ml-2">{{ $student['wa_number'] }}</span>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="p-4 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada murid yang menunggak.
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
