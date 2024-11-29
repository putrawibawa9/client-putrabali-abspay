<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\AbsenceService;
use App\Services\PaymentService;
use App\Services\StudentService;
use Illuminate\Support\Facades\Http;

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
   public function index( Request $request){
        $page = $request->query('page', 1);
        // dd($page);
         $students = $this->studentService->getAllStudents($page);
         $activeRoute = 'students';
        return view('pages.students.index', compact('students', 'activeRoute'));
    }

    // public function pagination ($page){
    //     dd($page);
    //      $students = $this->studentService->getAllStudents($page);
    
    //     return view('pages.students.index', compact('students'));
    // }

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
        // dd($request->all());
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'wa_number' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'enroll_date' => 'required|string|max:255',
        ]);
        $validatedData['wa_number'] = $this->formatWaNumber($validatedData['wa_number']);

        $error = $this->studentService->addNewStudent($validatedData);
   
        if ($error) {
            return redirect('/students')->with('error', $error['message']);
        }

        return redirect('/students')->with('success', 'Student added successfully');
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
    // implement the logic to compare the old data and new data
    $oldData = $this->studentService->getStudentById($id);
    $newData = $request->all();

    // Initialize an array to store only the changed data
    $updatedData = [];

    // Compare each field in the new data with the old data
    foreach ($newData as $key => $value) {
        // Skip if the key is not present in the old data
        if (!array_key_exists($key, $oldData)) {
            continue;
        }

        // Compare the values and only add the changed ones
        if ($value != $oldData[$key]) {
            $updatedData[$key] = $value;
        }
    }


     // Proceed with the next process only if there are changes
    if (!empty($updatedData)) {
       $error = $this->studentService->updateStudent($id, $updatedData);
    }

        if ($error) {
            return redirect('/students')->with('error', $error['message']);
        }
        return redirect('/students')->with('success', 'Student updated successfully');
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
    // also return the search value to be used in the view
    $activeRoute = 'students';
       return view('pages.students.index', compact('students', 'search', 'activeRoute'));

}


}
