<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\CourseService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AbsenceService;
use App\Services\PaymentService;
use App\Services\StudentService;
use App\Services\StudentCourseService;


class PaymentController extends Controller
{

     protected $studentService;
    protected $courseService;
    protected $studentCoursesService;
    protected $paymentService;
    protected $absenceService;
    public function __construct(StudentService $studentService, CourseService $courseService, StudentCourseService $studentCoursesService, PaymentService $paymentService, AbsenceService $absenceService)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->studentCoursesService = $studentCoursesService;
        $this->paymentService = $paymentService;
        $this->absenceService = $absenceService;
    }
    /**
     * Display a listing of the resource.
     */
       public function index( Request $request){
        $page = $request->query('page', 1);
       
         $students = $this->paymentService->getStudentsWithActiveCourse($page);
         
         $activeRoute = 'payments';
        return view('pages.payment.index', compact('students', 'activeRoute'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function paymentForm($id)
    {
        $student = $this->studentService->getStudentById($id);
        return view('payments.show', compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $this->paymentService->store($request->all());
        return redirect()->route('students.show',$request->student_id )->with('success', 'Payment has been successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = $this->studentService->getStudentById($id);
        // dd($student);
       $activeRoute = 'payments';
        return view('pages.payment.show', compact('student', 'activeRoute'));
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
        $payment = $this->paymentService->getStudentPayment($id);
         $absenceHistory = $this->absenceService->getStudentAbsencesHistory($id);
    
        return view('public.detail', compact('payment', 'absenceHistory'));
    }

    public function formPembayaranPrint($id)
    {
        
        $student = $this->studentService->getStudentById($id);
        // dd($student);
        $pdf = PDF::loadView('pages.payment.paymentForm', compact('student'));
        return $pdf->stream('form-pembayaran.pdf');
        
        
        // return view('pages.payment.paymentForm', compact('student'));
    
    }

    public function checkPaymentFromParents(){

        return view('public.search');
    }

    public function searchStudentFromParents(Request $request)
    {
        
        $search = $request->input('search');
        $students = $this->studentService->searchStudentByNisOrName($search);
       
        return view('public.search', compact('students', 'search'));
    }

    public function searchStudentByNisOrName(Request $request)
{
    
    $search = $request->input('search');
    $page = $request->query('page', 1);
    $students = $this->studentService->searchStudentByNisOrName($search, $page);
    // also return the search value to be used in the view
    
    $activeRoute = 'payments';
       return view('pages.payment.index', compact('students', 'search', 'activeRoute', 'search'));

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