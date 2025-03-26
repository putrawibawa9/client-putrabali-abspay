<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\StudentService;
use App\Services\StudentCourseService;

class StudentCourseController extends Controller
{

    protected $studentService;
    protected $courseService;
    protected $studentCourseService;
    public function __construct(StudentService $studentService, CourseService $courseService, StudentCourseService $studentCourseService)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->studentCourseService = $studentCourseService;
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

public function destroy($id){
    $this->studentCourseService->dropout($id);
    return redirect()->back()->with('success', "Student has been dropped out from the course");
}

}
