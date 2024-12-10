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
    //    dd($request->all());
        $courses = $this->courseService->search($request->all());
       
        if(isset($courses['message'])){
            return redirect()->route('courses.index')->with('error', $courses['message']);
        }
        $level = $request->input('level');
        $section = $request->input('section');
        $subject = $request->input('subject');
        // dd($courses);
        $activeRoute = 'courses';
        return view('pages.courses.index', compact('courses', 'activeRoute', 'level', 'section', 'subject'));

    }

     public function index( Request $request){
        $page = $request->query('page', 1);
         $courses = $this->courseService->getAllCourses($page);
         $activeRoute = 'courses';
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
        $data = $this->courseService->getCourseWithStudentsbyID($id);
        return view('courses.show', compact('data'));
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
    // implement the logic to compare the old data and new data
    $oldData = $this->courseService->getCoursebyId($id);
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

    // dd($updatedData);
     // Proceed with the next process only if there are changes
    if (!empty($updatedData)) {
       $error = $this->courseService->updateCourse($id, $updatedData);
    }
    
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
