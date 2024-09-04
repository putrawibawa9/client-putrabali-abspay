<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\StudentService;

class StudentCourseController extends Controller
{

    protected $studentService;
    protected $courseService;
    public function __construct(StudentService $studentService, CourseService $courseService)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
    }
    public function index(){
        $courses = $this->courseService->getAllCourses();
        return view('student-courses.index', compact( 'courses'));
    }

  public function show($alias)
{
    $courseWithStudents = $this->courseService->getCourseWithStudents($alias);

    $courses = $this->courseService->getAllCourses();
    return view('student-courses.index', compact('courseWithStudents', 'courses'));
}

}
