<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\PaymentService;
use App\Services\StudentService;
use App\Services\TeacherService;
use Illuminate\Support\Facades\Http;
use App\Services\StudentCourseService;
use App\Services\RecapitulationService;


class RecapitulationController extends Controller
{

 
    protected $recapitulationService;
    protected $teacherService;

     /**
     * Create a new controller instance.
     */
    public function __construct(RecapitulationService $recapitulationService, TeacherService $teacherService)
    {
        $this->recapitulationService = $recapitulationService;
        $this->teacherService = $teacherService;
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
   $financeCategory = Http::get(env('API_BASE_URL') . '/finance-entries')->json();
//    dd($financeCategory);
   return view('pages.dashboard.dashboard', compact('activeRoute', 'recapitulations', 'currentMonth', 'financeCategory'));
}

public function dailyRecap(Request $request)
{
    // Ambil parameter tanggal dari query, kalau tidak ada pakai awal & akhir bulan ini
    $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
    $endDate = $request->query('end_date', now()->format('Y-m-d'));
    $teacherId = $request->query('teacher_id');

    // Kirim request ke API
    $response = Http::get(env('API_BASE_URL') . '/meetings-daily-recap', [
        'start_date' => $startDate,
        'end_date' => $endDate,
        'teacher_id' => $teacherId,
    ]);

   

    $meetings = $response->successful() ? $response->json() : [];
    
    
    $activeRoute = 'daily-recap';
    $totalMeetings = count($meetings);
    $totalTeacherFee = array_sum(array_column($meetings, 'course_teacher_fee'));
    $teachers = $this->teacherService->getAllTeachers();
    

    return view('recapitulations.daily', compact(
        'meetings',
        'startDate',
        'endDate',
        'activeRoute',
        'totalMeetings',
        'totalTeacherFee',
        'teachers',
        
    ));
}

public function dailyRecapPayment(Request $request)
{
    // dd($request->all());
    // Ambil parameter tanggal dari query, kalau tidak ada pakai awal & akhir bulan ini
    $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
    $endDate = $request->query('end_date', now()->format('Y-m-d'));

    // Kirim request ke API
    $response = Http::get(env('API_BASE_URL') . '/payments-daily-recap', [
        'start_date' => $startDate,
        'end_date' => $endDate,
        'course_id' => $request->query('course_id'),
        'user_id' => $request->query('user_id'),
        'payment_month' => $request->query('payment_month'),
    ]);

    $courses =  Http::get(env('API_BASE_URL') . '/courses')->json();
    $users =  Http::get(env('API_BASE_URL') . '/users')->json();

    
    $payments = $response->successful() ? $response->json() : [];
    
    $activeRoute = 'daily-recap-payment';
    return view('recapitulations.daily-payment', compact(
        'payments',
        'startDate',
        'endDate',
        'activeRoute',
        'courses',
        'users'
    ));

}

  public function unpaid(Request $request){
              // Ambil parameter query (bisa override lewat URL)
        $month    = $request->query('month', now()->format('Y-m'));
        $courseId = $request->query('course_id');

        // Panggil API unpaid
        $response = Http::get(env('API_BASE_URL') . '/unpaid', [
            'month'     => $month,
            'course_id' => $courseId,
        ]);

        // Kalau sukses → ambil JSON, kalau gagal → kosongkan
        $unpaids = $response->successful() ? $response->json() : [];

        // Untuk tambahan filter UI, bisa juga fetch course list dsb kalau perlu
        $courses = Http::get(env('API_BASE_URL') . '/courses')->json();

        $activeRoute = 'courses';

        return view('recapitulations.unpaid', compact(
            'unpaids',
            'month',
            'courseId',
            'courses',
            'activeRoute'
        ));

    }

}