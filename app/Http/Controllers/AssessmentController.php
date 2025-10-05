<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\AbsenceService;
use App\Services\PaymentService;
use App\Services\StudentService;

class AssessmentController extends Controller
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
    
         $students = $this->studentService->getAllStudents($page);
        //  dd($students);
         $activeRoute = 'assessments';
        return view('pages.assessments.index', compact('students', 'activeRoute', 'englishCourses', 'mapelCourses'));
    }

    public function searchStudentByNisOrName(Request $request)
{
    $page = $request->query('page', 1);
    $search = $request->input('search');

    $students = $this->studentService->searchStudentByNisOrName($search, $page);

    // Optional: handle jika students berisi error
    if (isset($students['error'])) {
        return back()->with('error', $students['error']);
    }

    $englishCourses = $this->courseService->getCourseBySubject('english');
    $mapelCourses = $this->courseService->getCourseBySubject('mapel');
    $activeRoute = 'assessments';

    return view('pages.assessments.index', compact(
        'students',
        'search',
        'activeRoute',
        'englishCourses',
        'mapelCourses'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

// dd($request->all());
        // Validate input
        $validated = $request->validate([
            'student_id' => 'required|integer',
            'subject' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'score' => 'required|integer|min:0|max:100',
            'remarks' => 'nullable|string|max:1000',
        ]);

        // Send to API endpoint /assessments
        // dd($validated);

        $response = \Illuminate\Support\Facades\Http::post(env('API_BASE_URL', 'http://localhost:8000') . '/assessments', $validated);
// dd response
// dd($response->status());

        if ($response->successful()) {
            return redirect()->route('assessments.index')->with('success', 'Assessment submitted successfully!');
        } else {
        // return what is actual response from API
            $error = $response->json('error', 'Failed to submit assessment. Please try again.');
            return redirect()->back()->with('error', $error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get student data by ID
        $student = $this->studentService->getStudentById($id);
        $englishCourses = $this->courseService->getCourseBySubject('english');
        $mapelCourses = $this->courseService->getCourseBySubject('mapel');
        $activeRoute = 'assessments';

    
        // Show assessment input form for this student, pass assessment data
        return view('pages.assessments.input', compact('student', 'activeRoute', 'englishCourses', 'mapelCourses', ));
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
}
