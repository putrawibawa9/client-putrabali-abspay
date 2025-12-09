<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedule\ScheduleController;

Route::prefix('schedule')->name('schedule.')->group(function () {

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
});
