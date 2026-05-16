@extends('layouts.main')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-6 lg:px-8">
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Buat Recurring Schedule</h1>
            <p class="mt-2 max-w-2xl text-sm text-gray-600 dark:text-gray-300">
                Atur jadwal mingguan atau bulanan yang akan menjadi acuan meeting ke depan. Gunakan tanggal mulai dan mode impact untuk memastikan perubahan hanya menyentuh future meetings yang memang perlu diperbarui.
            </p>
        </div>
        <a href="{{ route('schedule.recurring.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
            Lihat Daftar Schedule
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">
            <p class="font-semibold">Form belum bisa disimpan.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div data-recurring-form>
            @include('schedules.partials.recurring-form', [
                'formId' => 'create-recurring-schedule',
                'action' => route('schedule.recurring.store'),
                'method' => 'POST',
                'schedule' => $schedule,
                'submitLabel' => 'Simpan Schedule',
                'courses' => $courses,
                'teachers' => $teachers,
                'frequencyOptions' => $frequencyOptions,
                'dayOptions' => $dayOptions,
                'impactMode' => $impactMode,
                'cancelUrl' => route('schedule.recurring.index'),
            ])
        </div>
    </div>
</div>
@endsection

@push('js')
    @include('schedules.partials.recurring-script')
@endpush
