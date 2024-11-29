<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\RecapitulationController;
use App\Http\Controllers\StudentCourseController;

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Entities
Route::resource('/students', StudentController::class);
Route::post('/students/search', [StudentController::class, 'searchStudentByNisOrName'])->name('students.search');
Route::post('/teachers/search', [TeacherController::class, 'searchTeacherByNameOrAlias'])->name('teachers.search');
Route::resource('/teachers', TeacherController::class);
Route::resource('/courses', CourseController::class);
// Route::get('/students?page={page}', [StudentController::class, 'pagination']);
// Operations
Route::resource('/payments', PaymentController::class);



Route::get('/students-schedules-check', [ScheduleController::class, 'index'])->name('students-schedules-check');

// routes/web.php
Route::get('/students-schedules', [ScheduleController::class, 'getStudentsSchedules'])->name('students.schedules');



Route::get('/enrollments', [EnrollmentController::class, 'index']);
Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');

Route::get('/absences', [AbsenceController::class, 'index']);

Route::post('/courses/search', [CourseController::class, 'search'])->name('courses.search');

Route::get('/student/payment/{id}', [PaymentController::class, 'getStudentPayment'])->name('student.payment');

Route::get('/formPembayaran/print/{id}', [PaymentController::class, 'formPembayaranPrint'])->name('formPembayaran.print');

Route::get('/students/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');

Route::get('/public/payments', [PaymentController::class, 'checkPaymentFromParents']);
// Route::post('/public/search', [StudentController::class, 'searchStudentByNisOrName']);

Route::get('/public/payments/{id}', [PaymentController::class, 'getStudentPaymentFromParents']);

Route::get('/students/payment/form', [PaymentController::class, 'index']);

Route::post('/students/payment/select', [PaymentController::class, 'paymentForm']);

Route::post('/students/payment/search', [PaymentController::class, 'searchStudentByNisOrName']);

// Absences
Route::get('/absences', [AbsenceController::class, 'allCourses']);

Route::post('/absences/search', [AbsenceController::class, 'searchCourse'])->name('absences.search');

Route::get('/absences/{id}', [AbsenceController::class, 'absenceForm'])->name('absences.show');

Route::post('/absences/store', [AbsenceController::class, 'store'])->name('absences.store');


// Recapitulation

Route::get('/recapitulations', [RecapitulationController::class, 'index']);
// Route::post('/recapitulations', [PaymentController::class, 'rexx']);
Route::post('/recapitulations/payment', [PaymentController::class, 'paymentRecapitulation'])->name('recapitulations.payment');

Route::post('/students/monthly-paid-unpaid', [PaymentController::class, 'paidAndUnpaidStudentsMonthly']);


// UPDATED VIEWS
Route::get('/updated-students', function () {
    return view('pages.students.index')->with('error', 'Fill all required fields!');
});

Route::get('/sufyan', function(){
    return view('update-views.pages.students.index');
});



Route::get('/test', [StudentController::class, 'studentPaginationTest']);