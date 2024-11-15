<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\StudentService;
use App\Services\StudentCourseService;
use App\Services\PaymentService;


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
   
    public function index(){
        $studentRecap = $this->studentService->getMonthlyEnrolledStudent();

        $paymentRecap = $this->paymentService->getMonthlyPayment(); 

        return view('recapitulations.index', compact('studentRecap', 'paymentRecap'));
    }
}