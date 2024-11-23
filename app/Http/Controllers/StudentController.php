<?php

namespace App\Http\Controllers;

use App\Services\AbsenceService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Services\StudentService;

class StudentController extends Controller
{
    protected $studentService;
    protected $paymentService;
    protected $absenceService;
     public function __construct(StudentService $studentService, PaymentService $paymentService, AbsenceService $absenceService)
    {
        $this->studentService = $studentService;
        $this->paymentService = $paymentService;
        $this->absenceService = $absenceService;
    }
    /**
     * Display a listing of the resource.
     */
   public function index(){
        // use student service to get all students
         $students = $this->studentService->getAllStudents();
   
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'wa_number' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'enroll_date' => 'required|string|max:255',
        ]);
        $validatedData['wa_number'] = $this->formatWaNumber($validatedData['wa_number']);

        $this->studentService->addNewStudent($validatedData);
        return redirect('/students');
    }

    /**
     * Display the specified resource.
     */
   public function show($id){
        // use student service to get student by id
        $student = $this->studentService->getStudentById($id);
        $payment = $this->paymentService->getStudentPayment($id);
        $absenceHistory = $this->absenceService->getStudentAbsencesHistory($id);
        return view('students.show', compact('student', 'payment', 'absenceHistory'));
   }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = $this->studentService->getStudentById($id);
        return view('students.update', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    // Get only the fields that have values in the request
    $data = $request->only(['name', 'school', 'enroll_date', 'wa_number']);
    
    // Filter out any fields that are empty or null
    $data = array_filter($data, function ($value) {
        return !is_null($value) && $value !== '';
    });

    
    $this->studentService->updateStudent($id, $data);
    return redirect('/students/' . $id);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected function formatWaNumber($wa_number)
{
    if (substr($wa_number, 0, 1) === '0') {
        return '62' . substr($wa_number, 1);
    }
    return $wa_number;
}

public function searchStudentByNisOrName(Request $request)
{
    $search = $request->input('search');

    $students = $this->studentService->searchStudentByNisOrName($search);
    return view('public.search', compact('students'));

}
}
