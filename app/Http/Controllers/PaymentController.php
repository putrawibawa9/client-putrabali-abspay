<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\StudentService;
use App\Services\StudentCourseService;
use App\Services\PaymentService;


class PaymentController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = $this->studentService->getAllStudents();
        $courses = $this->courseService->getAllCourses();
        return view('payments.index', compact('students', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'student_id' => 'required|numeric',
            'course_id' => 'required|numeric',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric',
            'payment_month' => 'required',
        ]);
        // call the payment services
        $response = $this->paymentService->store($request->all());
        // return the response
        return redirect()->route('payments.index')->with($response);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $allStudents = $this->studentService->getAllStudents();
        $student = $this->studentCoursesService->getStudentCourses($id);
        return view('payments.test', compact('allStudents', 'student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getStudentPayment($id)
    {
        $data = $this->paymentService->getStudentPayment($id);
        return view('payments.studentPayment', compact('data'));
    }

    public function formPembayaranPrint($id)
    {
        $student = $this->studentService->getStudentById($id);
        return view('forms.pembayaran', compact('student'));
    
    }
}
