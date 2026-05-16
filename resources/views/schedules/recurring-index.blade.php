@extends('layouts.main')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-6 lg:px-8">
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Recurring Schedule</h1>
            <p class="mt-2 max-w-3xl text-sm text-gray-600 dark:text-gray-300">
                Kelola semua jadwal berulang mingguan dan bulanan dari satu tempat. User bisa filter data, edit template recurring, lalu menonaktifkan schedule mulai tanggal tertentu tanpa membingungkan riwayat meeting yang sudah berjalan.
            </p>
        </div>
        <a href="{{ route('schedule.recurring.create') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
            Buat Schedule Baru
        </a>
    </div>

    @if (!empty($loadError))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">
            {{ $loadError }}
        </div>
    @endif

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total schedule</p>
            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $summary['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <p class="text-sm text-gray-500 dark:text-gray-400">Aktif</p>
            <p class="mt-2 text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $summary['active'] }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <p class="text-sm text-gray-500 dark:text-gray-400">Nonaktif</p>
            <p class="mt-2 text-2xl font-bold text-rose-600 dark:text-rose-400">{{ $summary['inactive'] }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <p class="text-sm text-gray-500 dark:text-gray-400">Mingguan</p>
            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $summary['weekly'] }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <p class="text-sm text-gray-500 dark:text-gray-400">Bulanan</p>
            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $summary['monthly'] }}</p>
        </div>
    </div>

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <form method="GET" action="{{ route('schedule.recurring.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
            <div>
                <label for="teacher_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Guru</label>
                <select id="teacher_id" name="teacher_id" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    <option value="">Semua guru</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher['id'] }}" {{ (string) ($filters['teacher_id'] ?? '') === (string) $teacher['id'] ? 'selected' : '' }}>
                            {{ $teacher['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="course_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Kelas</label>
                <select id="course_id" name="course_id" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    <option value="">Semua kelas</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course['id'] }}" {{ (string) ($filters['course_id'] ?? '') === (string) $course['id'] ? 'selected' : '' }}>
                            {{ $course['alias'] ?? $course['name'] ?? 'Tanpa nama kelas' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="frequency" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Frekuensi</label>
                <select id="frequency" name="frequency" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    <option value="">Semua frekuensi</option>
                    @foreach ($frequencyOptions as $value => $label)
                        <option value="{{ $value }}" {{ ($filters['frequency'] ?? '') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="is_active" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                <select id="is_active" name="is_active" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    <option value="">Semua status</option>
                    <option value="1" {{ ($filters['is_active'] ?? '') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ ($filters['is_active'] ?? '') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Filter
                </button>
                <a href="{{ route('schedule.recurring.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if ($schedules->isEmpty())
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-10 text-center shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Belum ada recurring schedule yang cocok dengan filter ini.</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Coba ubah filter atau buat schedule baru untuk mulai mengatur meeting berulang dari backend baru.</p>
        </div>
    @else
        <div class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900 lg:block">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/80">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-300">Kelas</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-300">Guru</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-300">Pola</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-300">Periode</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-300">Lokasi</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-300">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($schedules as $schedule)
                            @php
                                $editPanelId = 'edit-schedule-' . $schedule['id'];
                                $endPanelId = 'end-schedule-' . $schedule['id'];
                            @endphp
                            <tr class="align-top">
                                <td class="px-4 py-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $schedule['course_label'] }}</td>
                                <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200">{{ $schedule['teacher_label'] }}</td>
                                <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200">
                                    <p class="font-medium">{{ $schedule['recurrence_label'] }}</p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $schedule['time'] }} - {{ $schedule['end_time'] }}</p>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200">{{ $schedule['period_label'] }}</td>
                                <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200">{{ $schedule['location'] ?: '-' }}</td>
                                <td class="px-4 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $schedule['is_active'] ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300' }}">
                                        {{ $schedule['status_label'] }}
                                    </span>
                                    @if (!is_null($schedule['future_meetings_count']))
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ $schedule['future_meetings_count'] }} future meetings</p>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" data-schedule-panel-toggle="{{ $editPanelId }}" aria-expanded="false" class="inline-flex items-center justify-center rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-50 dark:border-blue-800 dark:text-blue-300 dark:hover:bg-blue-900/20">
                                            Edit
                                        </button>
                                        <button type="button" data-schedule-panel-toggle="{{ $endPanelId }}" aria-expanded="false" class="inline-flex items-center justify-center rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50 dark:border-rose-800 dark:text-rose-300 dark:hover:bg-rose-900/20">
                                            Nonaktifkan / Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr id="{{ $editPanelId }}" class="hidden">
                                <td colspan="7" class="bg-gray-50 px-4 py-5 dark:bg-gray-800/50">
                                    <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900" data-recurring-form>
                                        <div class="mb-4 flex items-start justify-between gap-3">
                                            <div>
                                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Edit {{ $schedule['course_label'] }}</h3>
                                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Perubahan akan mengikuti mode impact yang dipilih di bawah ini.</p>
                                            </div>
                                        </div>
                                        @include('schedules.partials.recurring-form', [
                                            'formId' => 'edit-recurring-' . $schedule['id'],
                                            'action' => route('schedule.recurring.schedule.update', $schedule['id']),
                                            'method' => 'PUT',
                                            'schedule' => $schedule,
                                            'submitLabel' => 'Update Schedule',
                                            'courses' => $courses,
                                            'teachers' => $teachers,
                                            'frequencyOptions' => $frequencyOptions,
                                            'dayOptions' => $dayOptions,
                                            'impactMode' => 'update_future',
                                            'showImpactNote' => true,
                                            'hiddenInputs' => $filters,
                                        ])
                                    </div>
                                </td>
                            </tr>
                            <tr id="{{ $endPanelId }}" class="hidden">
                                <td colspan="7" class="bg-gray-50 px-4 pb-5 dark:bg-gray-800/50">
                                    <div class="rounded-2xl border border-rose-200 bg-white p-4 dark:border-rose-900/50 dark:bg-gray-900">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Atur akhir schedule</h3>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Gunakan tanggal efektif agar hanya future meetings setelah tanggal itu yang terdampak. Ini aman untuk histori meeting yang sudah lewat.</p>
                                        <form method="POST" action="{{ route('schedule.recurring.schedule.destroy', $schedule['id']) }}" class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="teacher_id" value="{{ $filters['teacher_id'] ?? '' }}">
                                            <input type="hidden" name="course_id" value="{{ $filters['course_id'] ?? '' }}">
                                            <input type="hidden" name="is_active" value="{{ $filters['is_active'] ?? '' }}">
                                            <input type="hidden" name="frequency" value="{{ $filters['frequency'] ?? '' }}">
                                            <div>
                                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal efektif</label>
                                                <input type="date" name="effective_from" required value="{{ now()->toDateString() }}" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                            </div>
                                            <div>
                                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Aksi akhir</label>
                                                <select name="end_behavior" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                                    <option value="deactivate">Nonaktifkan schedule</option>
                                                    <option value="delete">Hapus schedule</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Impact mode</label>
                                                <select name="impact_mode" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                                    <option value="update_future">Update future meetings</option>
                                                    <option value="keep_existing">Keep existing generated meetings</option>
                                                    <option value="delete_future">Delete future meetings</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-3 flex justify-end">
                                                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
                                                    Simpan Perubahan Status
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4 lg:hidden">
            @foreach ($schedules as $schedule)
                @php
                    $mobileEditPanelId = 'mobile-edit-schedule-' . $schedule['id'];
                    $mobileEndPanelId = 'mobile-end-schedule-' . $schedule['id'];
                @endphp
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ $schedule['course_label'] }}</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $schedule['teacher_label'] }}</p>
                        </div>
                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $schedule['is_active'] ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300' }}">
                            {{ $schedule['status_label'] }}
                        </span>
                    </div>

                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500 dark:text-gray-400">Pola</dt>
                            <dd class="text-right font-medium text-gray-900 dark:text-white">{{ $schedule['recurrence_label'] }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500 dark:text-gray-400">Jam</dt>
                            <dd class="text-right font-medium text-gray-900 dark:text-white">{{ $schedule['time'] }} - {{ $schedule['end_time'] }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500 dark:text-gray-400">Periode</dt>
                            <dd class="text-right font-medium text-gray-900 dark:text-white">{{ $schedule['period_label'] }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500 dark:text-gray-400">Lokasi</dt>
                            <dd class="text-right font-medium text-gray-900 dark:text-white">{{ $schedule['location'] ?: '-' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                        <button type="button" data-schedule-panel-toggle="{{ $mobileEditPanelId }}" aria-expanded="false" class="inline-flex w-full items-center justify-center rounded-lg border border-blue-200 px-3 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-50 dark:border-blue-800 dark:text-blue-300 dark:hover:bg-blue-900/20">
                            Edit
                        </button>
                        <button type="button" data-schedule-panel-toggle="{{ $mobileEndPanelId }}" aria-expanded="false" class="inline-flex w-full items-center justify-center rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50 dark:border-rose-800 dark:text-rose-300 dark:hover:bg-rose-900/20">
                            Nonaktifkan / Hapus
                        </button>
                    </div>

                    <div id="{{ $mobileEditPanelId }}" class="hidden pt-4" data-recurring-form>
                        @include('schedules.partials.recurring-form', [
                            'formId' => 'mobile-edit-recurring-' . $schedule['id'],
                            'action' => route('schedule.recurring.schedule.update', $schedule['id']),
                            'method' => 'PUT',
                            'schedule' => $schedule,
                            'submitLabel' => 'Update Schedule',
                            'courses' => $courses,
                            'teachers' => $teachers,
                            'frequencyOptions' => $frequencyOptions,
                            'dayOptions' => $dayOptions,
                            'impactMode' => 'update_future',
                            'showImpactNote' => true,
                            'hiddenInputs' => $filters,
                        ])
                    </div>

                    <div id="{{ $mobileEndPanelId }}" class="hidden pt-4">
                        <form method="POST" action="{{ route('schedule.recurring.schedule.destroy', $schedule['id']) }}" class="space-y-4 rounded-2xl border border-rose-200 p-4 dark:border-rose-900/50">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="teacher_id" value="{{ $filters['teacher_id'] ?? '' }}">
                            <input type="hidden" name="course_id" value="{{ $filters['course_id'] ?? '' }}">
                            <input type="hidden" name="is_active" value="{{ $filters['is_active'] ?? '' }}">
                            <input type="hidden" name="frequency" value="{{ $filters['frequency'] ?? '' }}">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal efektif</label>
                                <input type="date" name="effective_from" required value="{{ now()->toDateString() }}" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Aksi akhir</label>
                                <select name="end_behavior" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="deactivate">Nonaktifkan schedule</option>
                                    <option value="delete">Hapus schedule</option>
                                </select>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Impact mode</label>
                                <select name="impact_mode" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="update_future">Update future meetings</option>
                                    <option value="keep_existing">Keep existing generated meetings</option>
                                    <option value="delete_future">Delete future meetings</option>
                                </select>
                            </div>
                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
                                Simpan Perubahan Status
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('js')
    @include('schedules.partials.recurring-script')
@endpush
