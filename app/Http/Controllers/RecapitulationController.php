<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\StudentService;
use App\Services\StudentCourseService;
use App\Services\PaymentService;
use Carbon\Carbon;


class RecapitulationController extends Controller
{

     protected $studentService;
    protected $courseService;
    protected $studentCoursesService;
    protected $paymentService;
    public function __construct(StudentService $studentService, CourseService $courseService, StudentCourseService $studentCoursesService, PaymentService $paymentService)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->studentCoursesService = $studentCoursesService;
        $this->paymentService = $paymentService;
    }
   
    public function index(Request $request)
{
    // Initialize variables
    $studentRecap = $this->studentService->getMonthlyEnrolledStudent();
    $paymentRecap = $this->paymentService->getMonthlyPayment();
    $data = null; // Default to null if no filtering is applied
    // Check if the request has a month filter
    if ($request->has('month')) {
        // Convert month to a string format
        $unformattedMonth = Carbon::createFromFormat('Y-m', $request->month);
        $month = $unformattedMonth->translatedFormat('F');

        // Fetch data based on the filtered month
        $data = $this->paymentService->paidAndUnpaidStudentsMonthly($month);
    }
    

    // Return the view with all data
    return view('recapitulations.index', compact('studentRecap', 'paymentRecap', 'data'));
}

}