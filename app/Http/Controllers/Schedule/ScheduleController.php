<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

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
        $response = $this->api->get("meeting/$id");
        $meeting = json_decode($response->getBody(), true);

        return view('schedule.update-meeting', compact('meeting'));
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
}
