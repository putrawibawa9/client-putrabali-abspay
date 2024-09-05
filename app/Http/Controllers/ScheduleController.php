<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScheduleService;

class ScheduleController extends Controller
{
     protected $scheduleService;
     public function __construct(ScheduleService $scheduleService,)
    {
        $this->scheduleService = $scheduleService;
    }
    public function index(){

        return view('schedules.index');
    }
    
    public function getStudentsSchedules(Request $request){
        $nis = $request->query('nis');
          $schedules = $this->scheduleService->getStudentSchedules($nis);
        return view('schedules.show', compact('schedules'));
    }
}
