<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeetingService;

class AbsenceController extends Controller
{
     protected $meetingService;
   public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }
    public function index()
    {
        $meetings = $this->meetingService->getAllMeetings();
        return view('test', compact('meetings'));
    }
}
