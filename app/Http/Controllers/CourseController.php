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
        $validatedData = $request->validate([
           'level' => 'required',
           'section' => 'required',
           'subject' => 'required',
           'alias'  => 'required',
           'payment_rate' => 'required',
        ]);

        $success =$this->courseService->addNewCourse($validatedData);
        if($success){
            return redirect()->route('courses.index');
        }
        // return redirect()->route('courses.index');
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
