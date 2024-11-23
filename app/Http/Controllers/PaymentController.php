<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\PaymentService;
use App\Services\StudentService;
use App\Services\StudentCourseService;


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
        // $courses = $this->courseService->getAllCourses();
        return view('payments.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function paymentForm(Request $request)
    {
        $id = $request->input('id');
        $student = $this->studentService->getStudentById($id);
        return view('payments.show', compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // validate the request
        //  dd(    $request->all());
        $request->validate([
            'student_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'course_id' => 'required|numeric',
            'type' => 'required|string',
            'payment_amount' => 'required|numeric',
            'payment_month' => 'required',
        ]);
        // call the payment services
        $this->paymentService->store($request->all());
        // return the response
        // return redirect()->route('/students');
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
        return view('students.show', compact('data'));
    }

    public function getStudentPaymentFromParents($id)
    {
        $data = $this->paymentService->getStudentPayment($id);
        return view('public.detail', compact('data'));
    }

    public function formPembayaranPrint($id)
    {
        $student = $this->studentService->getStudentById($id);
        return view('payments.paymentForm', compact('student'));
    
    }

    public function checkPaymentFromParents(){
        return view('public.search');
    }

    public function searchStudentByNisOrName(Request $request)
{
    $search = $request->input('search');
    $students = $this->studentService->searchStudentByNisOrName($search);
    // $courses = $this->courseService->getAllCourses();
    return view('payments.index', compact('students'));

}

public function recapitulation(){
    return view('overview.index');
}

public function paymentRecapitulation(Request $request){

    $request->validate([
        'start_date' => 'required',
        'start_date' => 'required',
    ]);
    $data = $this->paymentService->recapitulation($request->all());
    return view('overview.index', compact('data'));
}

public function paidAndUnpaidStudentsMonthly(Request $request){
    // get the month in string format
    // dd($request->month);
   $unformatedMonth = Carbon::createFromFormat('Y-m', $request->month);
  
     $month = $unformatedMonth->translatedFormat('F'); 
    //  dd($month);
    $data = $this->paymentService->paidAndUnpaidStudentsMonthly($month);
    return view('recapitulations.index', compact('data'));

}
}