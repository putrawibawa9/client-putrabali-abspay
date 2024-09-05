<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentCourseController;

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Entities
Route::resource('/students', StudentController::class);
Route::resource('/teachers', TeacherController::class);
Route::resource('/courses', CourseController::class);

// Operations
Route::resource('/payments', PaymentController::class);
Route::get('/students-courses', [StudentCourseController::class, 'index']);
Route::get('/students-courses/{alias}', [StudentCourseController::class, 'show']);

Route::get('/students-schedules-check', [ScheduleController::class, 'index'])->name('students-schedules-check');
// Route::get('/students-schedules?nis={nis}', [ScheduleController::class, 'getStudentsSchedules']);

// routes/web.php
Route::get('/students-schedules', [ScheduleController::class, 'getStudentsSchedules'])->name('students.schedules');

// Route::get('/schedules', [ScheduleController::class, 'index']);



Route::get('/enrollments', [EnrollmentController::class, 'index']);
Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');


