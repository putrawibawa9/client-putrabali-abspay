@php
    $formId = $formId ?? 'recurring-schedule-form';
    $method = strtoupper($method ?? 'POST');
    $schedule = $schedule ?? [];
    $submitLabel = $submitLabel ?? 'Simpan Schedule';
    $impactMode = $impactMode ?? ($schedule['impact_mode'] ?? 'update_future');
    $showImpactNote = $showImpactNote ?? true;
@endphp

<form id="{{ $formId }}" method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif
    @foreach (($hiddenInputs ?? []) as $hiddenName => $hiddenValue)
        <input type="hidden" name="{{ $hiddenName }}" value="{{ $hiddenValue }}">
    @endforeach

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label for="{{ $formId }}-course" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Kelas</label>
            <select id="{{ $formId }}-course" name="course_id" required class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <option value="">Pilih kelas</option>
                @foreach ($courses as $course)
                    <option value="{{ $course['id'] }}" {{ (string) old('course_id', $schedule['course_id'] ?? '') === (string) $course['id'] ? 'selected' : '' }}>
                        {{ $course['alias'] ?? $course['name'] ?? 'Tanpa nama kelas' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="{{ $formId }}-teacher" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Guru</label>
            <select id="{{ $formId }}-teacher" name="teacher_id" required class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <option value="">Pilih guru</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher['id'] }}" {{ (string) old('teacher_id', $schedule['teacher_id'] ?? '') === (string) $teacher['id'] ? 'selected' : '' }}>
                        {{ $teacher['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="{{ $formId }}-frequency" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Frekuensi</label>
            <select id="{{ $formId }}-frequency" name="frequency" data-frequency-select required class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                @foreach ($frequencyOptions as $value => $label)
                    <option value="{{ $value }}" {{ old('frequency', $schedule['frequency'] ?? 'weekly') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div data-weekly-field>
            <label for="{{ $formId }}-day-of-week" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Hari</label>
            <select id="{{ $formId }}-day-of-week" name="day_of_week" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <option value="">Pilih hari</option>
                @foreach ($dayOptions as $value => $label)
                    <option value="{{ $value }}" {{ old('day_of_week', $schedule['day_of_week'] ?? 'Monday') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div data-monthly-field>
            <label for="{{ $formId }}-day-of-month" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Bulanan</label>
            <input id="{{ $formId }}-day-of-month" type="number" name="day_of_month" min="1" max="31" value="{{ old('day_of_month', $schedule['day_of_month'] ?? 1) }}" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label for="{{ $formId }}-start-date" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Mulai Berlaku</label>
            <input id="{{ $formId }}-start-date" type="date" name="start_date" required value="{{ old('start_date', $schedule['start_date'] ?? '') }}" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label for="{{ $formId }}-end-date" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Berakhir Pada</label>
            <input id="{{ $formId }}-end-date" type="date" name="end_date" required value="{{ old('end_date', $schedule['end_date'] ?? '') }}" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label for="{{ $formId }}-time" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Jam Mulai</label>
            <input id="{{ $formId }}-time" type="time" name="time" required value="{{ old('time', $schedule['time'] ?? '') }}" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label for="{{ $formId }}-end-time" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Jam Selesai <span class="text-xs text-gray-400">(opsional)</span></label>
            <input id="{{ $formId }}-end-time" type="time" name="end_time" value="{{ old('end_time', $schedule['end_time'] ?? '') }}" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div class="md:col-span-2">
            <label for="{{ $formId }}-location" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Lokasi</label>
            <input id="{{ $formId }}-location" type="text" name="location" value="{{ old('location', $schedule['location'] ?? '') }}" placeholder="Contoh: Ruang Test B" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>
    </div>

    @if ($showImpactNote)
        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900 dark:border-blue-900/40 dark:bg-blue-900/20 dark:text-blue-100">
            <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                <div>
                    <p class="font-semibold">Impact ke future meetings</p>
                    <p class="mt-1 text-blue-800/90 dark:text-blue-100/80" data-impact-copy>
                        Perubahan ini akan diterapkan ke pertemuan mendatang setelah tanggal efektif. Riwayat meeting yang sudah lewat tetap aman.
                    </p>
                </div>
                <div class="w-full md:max-w-xs">
                    <label for="{{ $formId }}-impact-mode" class="mb-2 block text-xs font-semibold uppercase tracking-[0.12em] text-blue-700 dark:text-blue-200">Mode perubahan</label>
                    <select id="{{ $formId }}-impact-mode" name="impact_mode" data-impact-select class="block w-full rounded-lg border border-blue-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-blue-800 dark:bg-gray-800 dark:text-white">
                        <option value="update_future" {{ old('impact_mode', $impactMode) === 'update_future' ? 'selected' : '' }}>Update future meetings</option>
                        <option value="keep_existing" {{ old('impact_mode', $impactMode) === 'keep_existing' ? 'selected' : '' }}>Keep existing generated meetings</option>
                        <option value="delete_future" {{ old('impact_mode', $impactMode) === 'delete_future' ? 'selected' : '' }}>Delete future meetings</option>
                    </select>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
        @if (!empty($cancelUrl ?? null))
            <a href="{{ $cancelUrl }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
                Batal
            </a>
        @endif
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
            {{ $submitLabel }}
        </button>
    </div>
</form>
