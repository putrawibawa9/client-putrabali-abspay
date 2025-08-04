<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeetingService;

class MeetingController extends Controller
{

    protected $meetingService;
    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    public function getAbsencesByMeetingId($id)
    {
        $activeRoute    = 'courses';
     $students = $this->meetingService->getAbsencesByMeetingId($id);
     return view('pages.meetings.show', compact('students', 'activeRoute'));
}
}