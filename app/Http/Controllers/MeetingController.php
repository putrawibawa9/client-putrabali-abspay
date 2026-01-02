<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\MeetingService;
use Illuminate\Support\Facades\Http;

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

     public function teacherFutureSchedule($teacherId)
    {
        // Base URL API dari env
        $base = env('API_BASE_URL', 'http://localhost:8000/api');

        

        // Build URL API
        $url = "{$base}/scheduling/teacher/schedule";
        // dd($url);
        // Call API
        $response = Http::get($url, [
            'teacher_id' => $teacherId,
            'type'       => 'future'
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Gagal mengambil jadwal dari server API.');
        }

        // Data dari API
        $data = $response->json();
        // dd($data);
        // Nanti kirim ke view Blade (belum dibuat)
        return view('schedules.future', [
            'schedule'   => $data['data'] ?? [],
            'activeRoute'=> 'teacher-schedules',
            'teacher' => $data['teacher'] ?? [],
            'raw'        => $data, // kalau butuh debugging
        ]);
    }


    public function dailySchedule(Request $req)
    {
        $base = env('API_BASE_URL', 'http://localhost:8000/api');
 

        $date = $req->date ?? Carbon::today()->toDateString();
        $apiUrl = "$base/scheduling/dailyMeeting?date={$date}";
        // dd($apiUrl);

        $response = Http::get($apiUrl);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data dari API');
        }

        $data = $response->json();
        // dd($data);
        return view('schedules.daily', [
            'activeRoute' => 'schedule',
            'schedule' => $data
        ]);
    }
}
