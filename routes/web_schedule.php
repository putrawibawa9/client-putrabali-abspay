<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedule\ScheduleController;

Route::prefix('schedule')->name('schedule.')->group(function () {

    Route::get('/recurring', [ScheduleController::class, 'recurringIndex'])
        ->name('recurring.index');

    Route::get('/recurring/create', [ScheduleController::class, 'showRecurringCreateForm'])
        ->name('recurring.create');

    Route::post('/recurring', [ScheduleController::class, 'storeRecurringSchedule'])
        ->name('recurring.store');

    Route::put('/recurring/{scheduleId}', [ScheduleController::class, 'updateRecurringScheduleV2'])
        ->name('recurring.schedule.update');

    Route::delete('/recurring/{scheduleId}', [ScheduleController::class, 'destroyRecurringSchedule'])
        ->name('recurring.schedule.destroy');

    // FORM generate semester
    Route::get('/generate', [ScheduleController::class, 'showGenerateForm'])
        ->name('generate.form');

    Route::post('/generate', [ScheduleController::class, 'generateSemester'])
        ->name('generate.submit');

    // UPDATE SINGLE MEETING
    Route::get('/meeting/{id}/edit', [ScheduleController::class, 'showUpdateForm'])
        ->name('meeting.edit');

    Route::post('/meeting/{id}/update', [ScheduleController::class, 'updateMeeting'])
        ->name('meeting.update');

    // UPDATE RECURRING SCHEDULE
    Route::get('/course/{courseId}/recurring/edit', [ScheduleController::class, 'showRecurringForm'])
        ->name('recurring.form');

    Route::post('/course/{courseId}/recurring/update', [ScheduleController::class, 'updateRecurringSchedule'])
        ->name('recurring.update');

        Route::get('/teacher/{id}/schedule', [ScheduleController::class, 'index'])
    ->name('teacher.schedule');
    Route::get('/all-schedules', [ScheduleController::class, 'getAllSchedules'])->name('all-schedule');
});
