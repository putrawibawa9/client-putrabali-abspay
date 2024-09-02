<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentCourseController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::resource('/students', StudentController::class);
Route::resource('/courses-available', CourseController::class);
Route::get('/students-courses', [StudentCourseController::class, 'index']);
Route::post('/students-courses/{alias}', [StudentCourseController::class, 'show']);


Route::get('/enrollments', [EnrollmentController::class, 'index']);
Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');


