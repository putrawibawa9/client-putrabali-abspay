<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\AbsenceService;
use App\Services\CourseService;
use App\Services\PaymentService;
use App\Services\StudentService;
use Illuminate\Support\Facades\Http;

class StudentController extends Controller
{
    protected $studentService;
    protected $paymentService;
    protected $absenceService;
    protected $courseService;
     public function __construct(StudentService $studentService, PaymentService $paymentService, AbsenceService $absenceService, CourseService $courseService)
    {
        $this->studentService = $studentService;
        $this->paymentService = $paymentService;
        $this->absenceService = $absenceService;
        $this->courseService = $courseService;
    }
    /**
     * Display a listing of the resource.
     */
   public function index( Request $request){
    //    return current user session
     
        $page = $request->query('page', 1);
    $englishCourses = $this->courseService->getCourseBySubject('english');
    $mapelCourses = $this->courseService->getCourseBySubject('mapel');
    // dd($mapelCourses);
         $students = $this->studentService->getAllStudents($page);
        //  dd($students);
         $activeRoute = 'students';
        return view('pages.students.index', compact('students', 'activeRoute', 'englishCourses', 'mapelCourses'));
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
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'wa_number' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
        'school' => 'required|string|max:255',
        'enroll_date' => 'required|date',
        'course_id' => 'required|array', // Ensure course_id is an array
        'custom_payment_rate' => 'nullable|array', // Ensure custom_payment_rate is an array
    ]);

    // Format the WhatsApp number
    $validatedData['wa_number'] = $this->formatWaNumber($validatedData['wa_number']);

    // Prepare the courses array
    $courses = [];
    foreach ($validatedData['course_id'] as $index => $courseId) {
        // Skip if course_id is null or empty
        if (empty($courseId)) {
            continue;
        }

        // Add to courses array if course_id is valid
        $courses[] = [
            'course_id' => $courseId,
            'custom_payment_rate' => $validatedData['custom_payment_rate'][$index] ?? null,
        ];
    }

    // Remove any null or empty arrays from $courses
    $courses = array_filter($courses, function ($course) {
        return !empty($course['course_id']); // Keep only arrays with a non-empty course_id
    });

    // Prepare payload for the service
    $payload = [
        'name' => $validatedData['name'],
        'wa_number' => $validatedData['wa_number'],
        'gender' => $validatedData['gender'],
        'school' => $validatedData['school'],
        'enroll_date' => $validatedData['enroll_date'],
        'courses' => $courses,
    ];

    // Call the service to add a new student
    $result = $this->studentService->addNewStudent($payload);
    
    // Check if the result is an integer (student ID)
    if (is_int($result)) {
        return redirect("/students/$result")->with('success', 'Student added successfully');
    } else {
        return redirect('/students')->with('error', $result['message']);
    }
}

    /**
     * Display the specified resource.
     */
   public function show($id){
        // use student service to get student by id
        $student = $this->studentService->getStudentById($id);
        $payment = $this->paymentService->getStudentPayment($id);
        $absenceHistory = $this->absenceService->getStudentAbsencesHistory($id);
        $activeRoute = 'students';
        return view('pages.students.detail', compact('student', 'payment', 'absenceHistory', 'activeRoute'));
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
       $result = $this->studentService->updateStudent($id, $updatedData);
    }

        if (is_int($result)) {
        return redirect("/students/$result")->with('success', 'Student changed successfully');
    }else{
        return redirect('/students')->with('error', $result['message']);
    }
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
    // get the search value from the request
    $page = $request->query('page', 1);

    $search = $request->input('search');
  $englishCourses = $this->courseService->getAllCourses('english');
    $mapelCourses = $this->courseService->getAllCourses('mapel');
    $students = $this->studentService->searchStudentByNisOrName($search, $page);
    $search = $request->input('search');
    // also return the search value to be used in the view
    $activeRoute = 'students';
       return view('pages.students.index', compact('students', 'search', 'activeRoute', 'englishCourses', 'mapelCourses', 'search'));

}


}
