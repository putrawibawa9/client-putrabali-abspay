<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\CourseService;

class CourseController extends Controller
{
     protected $courseService;
   public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    /**
     * Display a listing of the resource.
     */

     public function search(Request $request)
    {
    
        $page = $request->query('page', 1);

        if ($request->has('alias')) {
            $alias = $request->input('alias');
            // If 'alias' is present, search by alias
            $courses = $this->courseService->searchByAlias(['alias' => $alias], $page);
        } else {
            // Otherwise, search by other criteria
            $courses = $this->courseService->search($request->all(), $page);
        }
  
        
      
        if(isset($courses['message'])){
            return redirect()->route('courses.index')->with('error', $courses['message']);
        }
        $level = $request->input('level', '');
        $section = $request->input('section', '');
        $subject = $request->input('subject', '');
        $alias = $request->input('alias', '');
        $isSearch = true;
        $activeRoute = 'courses';
    //    dd($courses);
        return view('pages.courses.index', compact('courses', 'activeRoute', 'level', 'section', 'subject', 'alias', 'isSearch'));

    }

     public function index( Request $request){
        $page = $request->query('page', 1);
       
         $courses = $this->courseService->getAllCourses($page);
         $activeRoute = 'courses';
        //  dd($courses);
        return view('pages.courses.index', compact('courses', 'activeRoute'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
           'level' => 'required',
           'section' => 'required',
           'subject' => 'required',
           'alias'  => 'required',
           'payment_rate' => 'required',
           'teaching_rate' => 'required',
              'lokasi_pb' => 'required',
        ]);


        $error =$this->courseService->addNewCourse($validatedData);
        // dd($error);
        if($error){
            return redirect()->route('courses.index')->with('error', $error['message']);
        }
        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meetings = $this->courseService->recapMeetings($id);
        $activeRoute = 'courses'; 
        return view('pages.meetings.index', compact('meetings', 'activeRoute'));
    }

    public function showCourseWithStudents(string $id)
    {
        $students = $this->courseService->getCourseWithStudentsbyID($id);
      
        $activeRoute = 'courses'; 
        return view('pages.courses.show', compact('students', 'activeRoute'));
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
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $oldData = $this->courseService->getCourseWithStudentsbyID($id);
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
    
        // If no fields were changed
        if (empty($updatedData)) {
            return redirect("/courses")->with('success', 'Tidak ada perubahan data.');
        }
    
        // Proceed with the update only if there are changes
        $error = $this->courseService->updateCourse($id, $updatedData);
    
        if ($error) {
            return redirect('/courses')->with('error', $error['message']);
        }
        
        return redirect('/courses')->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
