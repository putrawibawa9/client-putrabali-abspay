<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\MeetingService;

class MeetingController extends Controller
{
    protected $meetingService;
    protected $courseService;

    public function __construct(MeetingService $meetingService, CourseService $courseService)
    {
        $this->meetingService = $meetingService;
        $this->courseService = $courseService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activeRoute = 'meetings';
          $page = $request->query('page', 1);
       
         $courses = $this->courseService->getAllCourses($page);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
          $activeRoute    = 'meetings';
     $students = $this->meetingService->getAbsencesByMeetingId($id);
     return view('pages.meetings.show', compact('students', 'activeRoute'));
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
