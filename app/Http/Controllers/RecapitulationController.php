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
  
//    dd($recapitulations);
   return view('pages.dashboard.dashboard', compact('activeRoute', 'recapitulations', 'currentMonth'));
}

public function dailyRecap(Request $request)
{
    // Ambil parameter tanggal dari query
    $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
    $endDate   = $request->query('end_date', now()->format('Y-m-d'));
    $teacherId = $request->query('teacher_id');
    $lokasiPb  = $request->query('lokasi_pb'); // ✅ TAMBAHAN

    // Payload ke API (TETAP + lokasi_pb)
    $params = [
        'start_date' => $startDate,
        'end_date'   => $endDate,
    ];

    if (!empty($teacherId)) {
        $params['teacher_id'] = $teacherId;
    }

    if (!empty($lokasiPb)) {
        $params['lokasi_pb'] = (int) $lokasiPb;
    }

    // Kirim request ke API
    $response = Http::get(
        env('API_BASE_URL') . '/meetings-daily-recap',
        $params
    );

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
        'teachers'
    ));
}


 public function dailyRecapPayment(Request $request)
{
    // dd($request->all());
    // Default tanggal
    $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
    $endDate   = $request->input('end_date', now()->toDateString());

    // course_id[]
    $courseIds = collect($request->input('course_id', []))
        ->filter(fn ($v) => $v !== null && $v !== '')
        ->map(fn ($v) => is_numeric($v) ? (int) $v : $v)
        ->values()
        ->all();

    // =========================
    // PAYLOAD DASAR (TETAP)
    // =========================
    $payload = [
        'start_date' => $startDate,
        'end_date'   => $endDate,
    ];

    if (!empty($courseIds)) {
        $payload['course_id'] = $courseIds;
    }

    if ($request->filled('user_id')) {
        $payload['user_id'] = (int) $request->input('user_id');
    }

    if ($request->filled('teacher_id')) {
    $payload['teacher_id'] = (int) $request->input('teacher_id');
}


    if ($request->filled('payment_month')) {
        $payload['payment_month'] = $this->mapMonthIdToEn(
            strtolower($request->input('payment_month'))
        );
    }

    if ($request->filled('user_id')) {
    $payload['user_id'] = (int) $request->input('user_id');
}

if ($request->filled('teacher_id')) {
    $payload['teacher_id'] = (int) $request->input('teacher_id');
}

if ($request->filled('payment_month')) {
    $payload['payment_month'] = $this->mapMonthIdToEn(
        strtolower($request->input('payment_month'))
    );
}

// ✅ TAMBAHAN: type
if ($request->filled('type')) {
    $payload['type'] = $request->input('type');
}


    // =========================
    // 🔹 TAMBAHAN: lokasi_pb
    // =========================
    if ($request->filled('lokasi_pb')) {
        $payload['lokasi_pb'] = (int) $request->input('lokasi_pb');
    }

    // Kirim ke API
    $response = Http::asJson()
        ->timeout(20)
        ->post(env('API_BASE_URL') . '/payments-daily-recap', $payload);

    $payments = $response->successful() ? $response->json() : [
        'total_payment' => 0,
        'payments' => [],
        'error' => $response->json('message') ?? 'Failed to fetch data'
    ];

    // Dropdown data
    $courses = Http::get(env('API_BASE_URL') . '/courses')->json();

    // @dd($courses);```
    $users   = Http::get(env('API_BASE_URL') . '/users')->json();

    $teachers =Http::get(env('API_BASE_URL') . '/teachers')->json();

    // dd($teachers);

    $activeRoute = 'daily-recap-payment';

    return view('recapitulations.daily-payment', compact(
        'payments',
        'startDate',
        'endDate',
        'activeRoute',
        'courses',
        'users',
        'teachers'
    ));
}


    /**
     * Konversi nama bulan Indonesia -> English lowercase.
     * Jika tidak ketemu di map, kembalikan nilai aslinya (fail-safe).
     */
    private function mapMonthIdToEn(string $val): string
    {
        $monthMap = [
            'januari'   => 'january',
            'februari'  => 'february',
            'maret'     => 'march',
            'april'     => 'april',
            'mei'       => 'may',
            'juni'      => 'june',
            'juli'      => 'july',
            'agustus'   => 'august',
            'september' => 'september',
            'oktober'   => 'october',
            'november'  => 'november',
            'desember'  => 'desember', // <— hati-hati typo, ini memang "desember" di ID → "december" di EN
        ];

        // Perbaiki mapping "desember" → "december"
        if ($val === 'desember') {
            return 'december';
        }

        return $monthMap[$val] ?? $val;
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