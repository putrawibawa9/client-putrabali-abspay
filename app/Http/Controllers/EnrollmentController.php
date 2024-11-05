<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\StudentService;

class EnrollmentController extends Controller
{
protected $courseService;
protected $studentService;

 public function __construct(CourseService $courseService, StudentService $studentService)
    {
        $this->courseService = $courseService;
        $this->studentService = $studentService;
    }

public function index()
{
    $students = $this->studentService->getAllStudents();
    $courses = $this->courseService->getAllCourses();

    return view('courses.enrollment', compact('students', 'courses'));
        }


     public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'student_id' => 'required',
            'course_id' => 'required',
        ]);

        // Initialize Guzzle client
        $client = new Client();

        try {
            // Send POST request to the API endpoint
            $response = $client->post('localhost:8000/api/v1/enrollments', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $validatedData,
            ]);

            // Decode the JSON response
            $data = json_decode($response->getBody(), true);

            // Handle the response as needed
            return redirect()->route('students.index');

        } catch (\Exception $e) {
            // Handle exceptions or errors
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
