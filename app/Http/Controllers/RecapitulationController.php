<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\PaymentService;
use App\Services\StudentService;
use Illuminate\Support\Facades\Http;
use App\Services\StudentCourseService;
use App\Services\RecapitulationService;


class RecapitulationController extends Controller
{

 
    protected $recapitulationService;
    public function __construct(RecapitulationService $recapitulationService)
    {
        $this->recapitulationService = $recapitulationService;
    }
   
    public function index(Request $request)
{
    // dd($request->all());
    $month = $request->input('month');
    $year = $request->input('year');
    $recapitulations = $this->recapitulationService->getRecapitulations($month, $year);
    // dd($recapitulations);
   $currentMonth = Carbon::now()->format('F'); // Full month name
   $activeRoute ='dashboard';
   return view('pages.dashboard.dashboard', compact('activeRoute', 'recapitulations', 'currentMonth'));
}

public function dailyRecap(Request $request)
    {
       $date = $request->query('date', now()->format('Y-m-d'));

    $response = Http::get(env('API_BASE_URL') . '/meetings-daily-recap', [
    'date' => $date,
]);

// dd($response->json());
    $meetings = $response->successful() ? $response->json() : [];
    $activeRoute ='dashboard';
    $totalMeetings = count($meetings);
    $totalTeacherFee = array_sum(array_column($meetings, 'course_teacher_fee'));
    // dd($totalTeacherFee);
    return view('recapitulations.daily', compact('meetings', 'date', 'activeRoute', 'totalMeetings', 'totalTeacherFee'));
    }

}