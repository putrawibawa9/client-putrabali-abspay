<?php

namespace App\Http\Controllers\Schedule;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ScheduleController extends Controller
{
    private $api;

   protected $client;
    protected $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
         $this->baseUrl = config('services.api.base_url');
    }


    /* ===============================
        1. GENERATE SEMESTER
    ================================ */

    public function showGenerateForm()
    {

        $courses = $this->client->get($this->baseUrl . '/courses');
        $courses = json_decode($courses->getBody(), true);
        $courses = $courses['data'];
   
        $teachers = $this->client->get($this->baseUrl . '/teachers');
        $teachers = json_decode($teachers->getBody(), true);    
        $teachers = $teachers['data'];
  

        $activeRoute    = 'generate-semester';
        return view('schedules.generate', compact('activeRoute', 'courses', 'teachers'));
    }

 public function generateSemester(Request $request)
{
    try {

        $payload = [
            'course_id'   => $request->course_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'schedule'    => $request->schedule
        ];
     
        // coba test uri yang benar
// dd($payload);
     
        $response = $this->client->post($this->baseUrl . '/scheduling/generateSemester', [
            'headers' => [
                    'Accept' => 'application/json',
                ],
            'json' => $payload
        ]);
     
        $data = json_decode($response->getBody(), true);

        return back()->with('success', $data['message']);

    } catch (\GuzzleHttp\Exception\ClientException $e) {

        $response = $e->getResponse();
        $body = json_decode($response->getBody()->getContents(), true);

        /** ------------------------------
         *  HANDLE VALIDATION ERROR (422)
         * ------------------------------ */
        if ($response->getStatusCode() === 422) {

            // PRIORITAS: gunakan message singkat bawaan BE
            $mainMessage = $body['message'] ?? 'Terjadi kesalahan validasi.';

            return back()
                ->with('error', $mainMessage)
                ->withErrors($body['errors'] ?? [])
                ->withInput();
        }

        /** ------------------------------
         *  HANDLE ERROR LAIN
         * ------------------------------ */
        return back()->with('error', 'Server Error.')->withInput();
    }
}






    /* ===============================
        2. UPDATE SINGLE MEETING
    ================================ */

    public function showUpdateForm($id)
    {

        $response = $this->client->get($this->baseUrl . '/scheduling/meeting/' . "$id");
      
        $meeting = json_decode($response->getBody(), true);
       $activeRoute    = 'update-meeting';

        return view('schedules.update-meeting', compact('meeting', 'activeRoute'));
    }

    public function updateMeeting(Request $request, $id)
    {
        $payload = $request->only(['teacher_id', 'date', 'time', 'location']);

        $response = $this->api->post("meeting/$id/update", [
            'json' => $payload
        ]);

        $data = json_decode($response->getBody(), true);

        return redirect()->back()->with('success', $data['message']);
    }


    /* ===============================
        3. UPDATE RECURRING SCHEDULE
    ================================ */

    public function showRecurringForm($courseId)
    {
        return view('schedule.update-recurring', compact('courseId'));
    }

    public function updateRecurringSchedule(Request $request, $courseId)
    {
        $payload = [
            'old_day'        => $request->old_day,
            'new_day'        => $request->new_day,
            'new_time'       => $request->new_time,
            'effective_from' => $request->effective_from,
            'teacher_id'     => $request->teacher_id,
            'location'       => $request->location
        ];

        $response = $this->api->post("course/$courseId/change-recurring-schedule", [
            'json' => $payload
        ]);

        $data = json_decode($response->getBody(), true);

        return redirect()->back()->with('success', $data['message']);
    }


     public function index($id, Request $req)
    {
      
        $type = $req->type ?? 'future';

        $base = env('API_BASE_URL', 'http://localhost:8000/api');
   

        $url = "{$base}/scheduling/schedule";
// dd($url);
        $response = Http::get($url, [
            'teacher_id' => $id,
            'type'       => $type
        ]);
        // dd($response->json());

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil jadwal guru.');
        }

        $schedule = $response->json();

        return view('schedules.teacher-schedules', [
            'activeRoute' => 'teacher-schedule',
            'teacherId' => $id,
            'type'      => $type,
            'schedule'  => $schedule['data'] ?? [],
            'count'     => $schedule['count'] ?? 0,
        ]);
    }


    public function getAllSchedules(){
        $response = $this->client->get($this->baseUrl . '/scheduling/all-schedules');
        // dd($response);
        $schedules = json_decode($response->getBody(), true);
        $schedules = $schedules['data'];
// dd($schedules);

$teachers = $this->client->get($this->baseUrl . '/teachers');
// dd($teachers);
$teachers = json_decode($teachers->getBody(), true);    
$teachers = $teachers['data'];
// dd($teachers);
$courses = $this->client->get($this->baseUrl . '/courses');
$courses = json_decode($courses->getBody(), true);    
$courses = $courses['data'];
// dd($courses);
        $activeRoute    = 'all-schedules';
        return view('schedules.all-schedule', compact('activeRoute', 'schedules', 'teachers', 'courses') );
    }
}
