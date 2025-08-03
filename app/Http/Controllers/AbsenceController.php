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

       $page = $request->query('page', 1);
        $courses = $this->courseService->search($request->all(), $page);
       
        if(isset($courses['message'])){
            return redirect()->route('absences.index')->with('error', $courses['message']);
        }
        
        $level = $request->input('level');
        $section = $request->input('section');
        $subject = $request->input('subject');
        $isSearch = true;
       
        $activeRoute = 'absences';
        return view('pages.absences.index', compact('courses', 'activeRoute', 'level', 'section', 'subject', 'isSearch'));

    }

    public function searchCoursesByAlias(Request $request)
{
    $page = $request->query('page', 1);

    // Use 'alias' input directly
    $alias = $request->input('alias');

    // If your CourseService accepts a unified 'alias' key
    $courses = $this->courseService->searchByAlias(['alias' => $alias], $page);

    if (isset($courses['message'])) {
        return redirect()->route('absences.index')->with('error', $courses['message']);
    }

    $isSearch = true;
    $activeRoute = 'absences';
 
    // Pass alias to the view instead of level/section/subject
    return view('pages.absences.index', compact('courses', 'activeRoute', 'alias', 'isSearch'));
}



 public function allCourses(Request $request){
    // dd($request);
     $page = $request->query('page', 1);
        $courses = $this->courseService->getAllCourses($page);
        $activeRoute = 'absences';
        return view('pages.absences.index', compact('courses', 'activeRoute'));
    }
   

    public function absenceInput( $id){
     
           $data = $this->courseService->getCourseWithStudentsbyID($id);
            // dd($data);
           $teachers = $this->teacherService->getAllTeachers();
           $activeRoute = 'absences';
             return view('pages.absences.input', compact('data', 'teachers', 'activeRoute'));
    }

    public function store(Request $request)
{
// dd($request->all());
    // Extract day from the date
    $date = $request->input('date');
    $day = date('l', strtotime($date));

    $data = $request->all();
    $data['day'] = $day;
    // Extract basic data for the API request
    $apiRequestData = [
        "day" => $data["day"],
        "date" => $data["date"],
        "time" => $data["final_time"],
        "course_id" => (int)$data["course_id"],
        "teacher_id" => (int)$data["teacher_id"],
    ];
    
    // Add attendances to the request data
    $apiRequestData["attendances"] = $data["attendances"];

    // dd($apiRequestData);

    // Now you can pass $apiRequestData to your service or API client
    $error = $this->absenceService->store($apiRequestData);
    // dd($error);
    if ($error) {
        return redirect()->route("absences.index")->with('error', $error['message']);
    }

   
    return redirect()->route('recap-teacher-absences', ['id' => (int)$data["teacher_id"] ])
    ->with('success', 'Absence recorded successfully');
}


    
}
