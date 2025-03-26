<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\RecapitulationController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Middleware\CheckUserSession;


Route::middleware([CheckUserSession::class])->group(function () {

    // students
    Route::resource('/students', StudentController::class);
    Route::resource('/student-course', StudentCourseController::class)->only(['destroy', 'store']);
    
    Route::get('/students-search', [StudentController::class, 'searchStudentByNisOrName'])->name('students.search');
    Route::get('/teachers-search', [TeacherController::class, 'searchTeacherByNameOrAlias'])->name('teachers.search');
    Route::get('/student/payment/{id}', [PaymentController::class, 'getStudentPayment'])->name('student.payment');
    Route::get('/students-schedules-check', [ScheduleController::class, 'index'])->name('students-schedules-check');
    Route::get('/students-schedules', [ScheduleController::class, 'getStudentsSchedules'])->name('students.schedules');
    Route::get('/enrollments', [EnrollmentController::class, 'index']);
    Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::get('/students/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::get('/students/payment/form', [PaymentController::class, 'index']);
    Route::post('/students/payment/select', [PaymentController::class, 'paymentForm']);
    Route::post('/students/payment/search', [PaymentController::class, 'searchStudentByNisOrName']);

    // teachers
    Route::resource('/teachers', TeacherController::class);

    // courses
    Route::resource('/courses', CourseController::class);
    Route::get('/courses-search', [CourseController::class, 'search'])->name('courses.search');

    // payments
    Route::resource('/payments', PaymentController::class);
    Route::get('/payments-search', [PaymentController::class, 'searchStudentByNisOrName'])->name('payments.search');
    Route::get('/formPembayaran/print/{id}', [PaymentController::class, 'formPembayaranPrint'])->name('formPembayaran.print');
  

    

    // Meetings
    Route::get('/meetings/{id}', [MeetingController::class, 'getAbsencesByMeetingId']);

    // Recapitulation
    Route::get('/recapitulations', [RecapitulationController::class, 'index']);
    Route::post('/recapitulations/payment', [PaymentController::class, 'paymentRecapitulation'])->name('recapitulations.payment');
    Route::post('/students/monthly-paid-unpaid', [PaymentController::class, 'paidAndUnpaidStudentsMonthly']);

    // Dashboard
    Route::get('/dashboard', [RecapitulationController::class, 'index'])->name('dashboard')->middleware(CheckUserSession::class);
});


// authentications
Route::get('/', [AuthenticationController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/login/teacher', [AuthenticationController::class, 'loginTeacher'])->name('login.teacher');

Route::post('/register', [AuthenticationController::class, 'register']);
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');


// for student or parents
  Route::get('/public/check-status', [PaymentController::class, 'checkPaymentFromParents'])->name('check-status');
    Route::get('/public/check-status/search', [PaymentController::class, 'searchStudentFromParents'])->name('check-status.search');
    Route::get('/public/check-status/{id}', [PaymentController::class, 'getStudentPaymentFromParents']);



    // for teachers
    Route::get('/absences/input/{id}', [AbsenceController::class, 'absenceInput']);
    Route::get('/absences', [AbsenceController::class, 'allCourses'])->name('absences.index');
    Route::get('/absence/courses/search', [AbsenceController::class, 'searchCourses'])->name('absence.courses.search');
    Route::post('/absences/search', [AbsenceController::class, 'searchCourse'])->name('absences.search');
    Route::get('/absences/{id}', [AbsenceController::class, 'absenceForm'])->name('absences.show');
    Route::post('/absences/store', [AbsenceController::class, 'store'])->name('absences.store');