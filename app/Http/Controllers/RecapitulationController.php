<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\StudentService;
use App\Services\StudentCourseService;
use App\Services\PaymentService;
use App\Services\RecapitulationService;
use Carbon\Carbon;


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

}