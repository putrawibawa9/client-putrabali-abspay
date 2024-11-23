<?php

namespace App\Http\Controllers;

use App\Services\AbsenceService;
use Illuminate\Http\Request;
use App\Services\MeetingService;
use App\Services\CourseService;
use App\Services\TeacherService;

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
    public function searchCourse(Request $request)
    {
        $courses = $this->courseService->search($request->all());
    
        return view('absences.selectCourse', compact('courses'));

    }
 public function allCourses(){
        $courses = $this->courseService->getAllCourses();
  
        return view('absences.selectCourse', compact('courses'));
    }

    public function absenceForm( $id){
        // dd($id);
           $data = $this->courseService->getCourseWithStudentsbyID($id);
           $teachers = $this->teacherService->getAllTeachers();
        return view('absences.absenceForm', compact('data', 'teachers'));
    }

    public function store(Request $request){
        $data = $request->all();
        $this->absenceService->store($data);
        return redirect()->route('absences.show', $data['course_id']);
    
    }

    
}
