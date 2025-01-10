<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\AbsenceService;
use App\Services\MeetingService;
use App\Services\TeacherService;
use Illuminate\Support\Facades\Session;

class AbsenceController extends Controller
{
     protected $meetingService;
      protected $courseService;
      protected $teacherService;
      protected $absenceService;
   public function __construct(MeetingService $meetingService, CourseService $courseService, TeacherService $teacherService, AbsenceService $absenceService)
    {
        $this->meetingService = $meetingService;
        $this->courseService = $courseService;
        $this->teacherService = $teacherService;
        $this->absenceService = $absenceService;
    }
   

    public function searchCourses(Request $request)
    {
       
        $courses = $this->courseService->search($request->all());
       
        if(isset($courses['message'])){
            return redirect()->route('absences.index')->with('error', $courses['message']);
        }
        $level = $request->input('level');
        $section = $request->input('section');
        $subject = $request->input('subject');
        // dd($courses);
        $activeRoute = 'absences';
        return view('pages.absences.index', compact('courses', 'activeRoute', 'level', 'section', 'subject'));

    }


 public function allCourses(Request $request){
     $page = $request->query('page', 1);
        $courses = $this->courseService->getAllCourses($page);
        $activeRoute = 'absences';
        return view('pages.absences.index', compact('courses', 'activeRoute'));
    }
   

    public function absenceInput( $id){
        //  if (!Session::has('user_logged_in')) {
        //   return redirect()->route('login');
        // }
           $data = $this->courseService->getCourseWithStudentsbyID($id);
           $teachers = $this->teacherService->getAllTeachers();
           $activeRoute = 'absences';
             return view('pages.absences.input', compact('data', 'teachers', 'activeRoute'));
    }

    public function store(Request $request)
{
    // Extract day from the date
    $date = $request->input('date');
    $day = date('l', strtotime($date));

    $data = $request->all();
    $data['day'] = $day;
    // Extract basic data for the API request
    $apiRequestData = [
        "day" => $data["day"],
        "date" => $data["date"],
        "time" => $data["time"],
        "course_id" => (int)$data["course_id"],
        "teacher_id" => (int)$data["teacher_id"],
    ];

    // Prepare attendances array
    $attendances = [];
    foreach ($data as $key => $value) {
        // Check if the key matches the attendance field pattern
        if (str_starts_with($key, "students_courses_id-")) {
            $studentsCoursesId = (int)str_replace("students_courses_id-", "", $key);

            $attendances[] = [
                "students_courses_id" => $studentsCoursesId,
                "status" => $value,
            ];
        }
    }

    // Add attendances to the request data
    $apiRequestData["attendances"] = $attendances;

// dd($apiRequestData);
    // Now you can pass $apiRequestData to your service or API client
    $error = $this->absenceService->store($apiRequestData);
    // dd($error);
    if ($error) {
        return redirect()->route("absences.index")->with('error', $error['message']);
    }

    return redirect()->route("absences.index")->with('success', 'Absence recorded successfully');
}


    
}
