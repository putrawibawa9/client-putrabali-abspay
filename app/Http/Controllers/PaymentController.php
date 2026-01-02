<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\CourseService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AbsenceService;
use App\Services\PaymentService;
use App\Services\StudentService;
use Illuminate\Support\Facades\Http;
use App\Services\StudentCourseService;


class PaymentController extends Controller
{

       protected $client;
    protected $baseUrl;

   

     protected $studentService;
    protected $courseService;
    protected $studentCoursesService;
    protected $paymentService;
    protected $absenceService;
    public function __construct(StudentService $studentService, CourseService $courseService, StudentCourseService $studentCoursesService, PaymentService $paymentService, AbsenceService $absenceService, Client $client)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->studentCoursesService = $studentCoursesService;
        $this->paymentService = $paymentService;
        $this->absenceService = $absenceService;
        $this->client = $client;
         $this->baseUrl = config('services.api.base_url');
    }
    /**
     * Display a listing of the resource.
     */
       public function index( Request $request){
        $page = $request->query('page', 1);
       
         $students = $this->paymentService->getStudentsWithActiveCourse($page);
         
         $activeRoute = 'payments';
        return view('pages.payment.index', compact('students', 'activeRoute'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function paymentForm($id)
    {
        $student = $this->studentService->getStudentById($id);
    
        return view('payments.show', compact('student', 'payment'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    
    // Safety: pastikan ada array 'courses'
    $courses = $request->input('courses', []);
    if (!is_array($courses) || empty($courses)) {
        return back()->with('error', 'Tidak ada data kursus yang dikirim.');
    }

    $studentId = $request->input('student_id');
    $actor     = $request->input('actor');
    $userId    = $request->input('user_id');

    // Normalisasi & filter: kirim HANYA item yang dibayar
    $filtered = collect($courses)
        ->map(function ($c) {
            // Normalisasi value kosong
            $c['type']           = $c['type']           ?? '';
            $c['payment_month']  = ($c['payment_month'] ?? '') === '' ? null : $c['payment_month'];
            $c['payment_year']   = $c['payment_year']   ?? null;
            $c['course_id']      = $c['course_id']      ?? null;
            $c['payment_date']   = $c['payment_date']   ?? null;
            // payment_amount bisa "" (string kosong) dari input number
            $c['payment_amount'] = isset($c['payment_amount']) && $c['payment_amount'] !== ''
                ? (int)$c['payment_amount'] : null;
            return $c;
        })
        ->filter(function ($c) {
            // Hanya kirim:
            // - SPP dengan nominal > 0
            // - modul/pendaftaran/ujian (nominal boleh null; server set 50000)
            if (empty($c['type'])) return false;
            if ($c['type'] === 'spp') {
                return !empty($c['payment_date']) && !empty($c['course_id']) && ($c['payment_amount'] >= 0);
            }
            // Non-SPP: cukup ada tanggal & course_id; amount boleh null (server akan set 50000)
            return !empty($c['payment_date']) && !empty($c['course_id']);
        })
        ->values();

    // Validasi sisi client: spp yang dikirim WAJIB punya bulan
    foreach ($filtered as $c) {
        if ($c['type'] === 'spp' && ($c['payment_amount'] ?? 0) > 0) {
            if (empty($c['payment_month'])) { // "" atau null dianggap kosong
                return back()->with('error', 'Tolong masukkan bulan pembayaran untuk SPP.');
            }
        } else {
            // Untuk non-SPP, rapikan: pastikan payment_month null
            $c['payment_month'] = null;
        }
    }

    if ($filtered->isEmpty()) {
        return back()->with('error', 'Tidak ada pembayaran yang valid. Isi nominal atau pilih jenis pembayaran yang tepat.');
    }

    // Siapkan payload akhir
    
    $payload = [
        'student_id' => $studentId,
        'courses'    => $filtered->map(function ($c) {
            return [
                'course_id'      => $c['course_id'],
                'payment_date'   => $c['payment_date'],
                'payment_month'  => $c['type'] === 'spp' ? $c['payment_month'] : null,
                'payment_year'   => $c['type'] === 'spp' ? $c['payment_year'] : null,
                'type'           => $c['type'],
                'payment_amount' => $c['payment_amount'], // boleh null untuk non-SPP; server set 50000
            ];
        })->all(),
    ];

    // dd($payload);
    // Tentukan aktor
    if ($actor === 'teacher') {
        $payload['teacher_id'] = $userId;
    } elseif ($actor === 'admin') {
        $payload['user_id'] = $userId;
    }

    // Kirim ke service
    $error = $this->paymentService->stor                                                                   e($payload);

    if (isset($error['message'])) {
        return back()->with('error', $error['message']);
    }

    return back()->with('success', 'Payment has been successfully added');
}



    /**
     * Display the specified resource.
     */
  public function show($id)
{
    // 1. GET monthly payment dari API
    $response = $this->client->get(
        $this->baseUrl . '/students/' . $id . '/monthly-payment',
        [
            'timeout' => 10,
            'headers' => ['Accept' => 'application/json'],
        ]
    );

    $course_price = json_decode($response->getBody(), true);


    // 2. GET student + payment seperti biasa
    $student = $this->studentService->getStudentById($id);
    $payment = $this->paymentService->getStudentPayment($id);

    // ===============================================
    // 3. MERGE course_price KE DALAM student['active_courses']
    // ===============================================

    // Buat map: course_id → data pricing bulan ini
    $priceMap = collect($course_price['courses'])
        ->mapWithKeys(fn($c) => [
            $c['course_id'] => [
                'final_price'    => $c['final_price_this_month'],
                'default_rate'   => $c['default_rate'],
                'override_price' => $c['override_price'],
            ]
        ]);

    // Inject field 'monthly_price' ke setiap course aktif
    $student['active_courses'] = collect($student['active_courses'])->map(function ($course) use ($priceMap) {

        $courseId = $course['id'];

        if (isset($priceMap[$courseId])) {
            $course['monthly_price']  = $priceMap[$courseId]['final_price'];
            $course['default_rate']   = $priceMap[$courseId]['default_rate'];
            $course['override_price'] = $priceMap[$courseId]['override_price'];
        } else {
            // fallback (misal tidak ada di API)
            $course['monthly_price'] = $course['payment_rate'];
            $course['default_rate'] = $course['payment_rate'];
            $course['override_price'] = null;
        }

        return $course;
    });
    // ===============================================


    $activeRoute = 'students';
// dd($course_price);
    return view('pages.payment.show', compact(
        'student', 'payment', 'activeRoute', 'course_price'
    ));
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

    public function getStudentPayment($id)
    {
        $data = $this->paymentService->getStudentPayment($id);
        return view('students.show', compact('data'));
    }

   public function getStudentPaymentFromParents($id)
{
    // ambil data payment & absence seperti semula
    $payment = $this->paymentService->getStudentPayment($id);
    $absenceHistory = $this->absenceService->getStudentAbsencesHistory($id);

  // --- panggil API scheduling (frontend -> backend API) ---
$base = env('API_BASE_URL', 'http://localhost:8000/api/v1/scheduling');
$apiUrl = rtrim($base, '/') . "/scheduling/student";
// dd($apiUrl);
// default fallback jika API gagal
$schedule = [
    'student_id' => $id,
    'generated'  => now()->toDateTimeString(),
    'count'      => 0,
    'schedule'   => []
];

try {
    $response = Http::get($apiUrl, [
        'student_id' => $id
    ]);

    if ($response->successful()) {
        $json = $response->json();

        // mapping sesuai response backend
        $schedule = [
            'student_id' => $json['student_id'] ?? $id,
            'generated'  => $json['generated'] ?? now()->toDateTimeString(),
            'count'      => $json['count'] ?? 0,
            'schedule'   => $json['schedule'] ?? []
        ];
        // dd($schedule);
    } else {
     
    }
} catch (\Throwable $e) {
   
}

// dd($schedule);
    // kirim semua data ke view
    return view('public.detail', compact('payment', 'absenceHistory', 'schedule'));
}

    public function formPembayaranPrint($id)
    {
        
        $student = $this->studentService->getStudentById($id);
        // dd($student);
        $pdf = PDF::loadView('pages.payment.paymentForm', compact('student'));
        return $pdf->stream('form-pembayaran.pdf');
        
        
        // return view('pages.payment.paymentForm', compact('student'));
    
    }

    public function checkPaymentFromParents(){
        // dd('masuk');
        return view('public.search');
    }

    public function searchStudentFromParents(Request $request)
    {
        
        $search = $request->input('search');
        $students = $this->studentService->searchStudentByNisOrName($search);
      
        return view('public.search', compact('students', 'search'));
    }

    public function searchStudentByNisOrName(Request $request)
{
    
    $search = $request->input('search');
    $page = $request->query('page', 1);
    $students = $this->studentService->searchStudentByNisOrName($search, $page);
    // also return the search value to be used in the view
    
    $activeRoute = 'payments';
       return view('pages.payment.index', compact('students', 'search', 'activeRoute', 'search'));

}

public function recapitulation(){
    return view('overview.index');
}

public function paymentRecapitulation(Request $request){

    $request->validate([
        'start_date' => 'required',
        'start_date' => 'required',
    ]);
    $data = $this->paymentService->recapitulation($request->all());
    return view('overview.index', compact('data'));
}

public function paidAndUnpaidStudentsMonthly(Request $request){
    // get the month in string format
    // dd($request->month);
   $unformatedMonth = Carbon::createFromFormat('Y-m', $request->month);
  
     $month = $unformatedMonth->translatedFormat('F'); 
    //  dd($month);
    $data = $this->paymentService->paidAndUnpaidStudentsMonthly($month);
    return view('recapitulations.index', compact('data'));

}

public function generateReceipt($id)
{

     $base = env('API_BASE_URL', 'http://localhost:8000/api'); // Base URL API
    

        // Endpoint: /payments/{id}/receipt (contoh: /payments/15/receipt)
        $endpoint = "{$base}/payments/{$id}/receipt";

        $res = Http::acceptJson()->get($endpoint);
        if (!$res->ok()) {
            abort(502, 'Gagal mengambil data kwitansi dari API.');
        }

        $p = $res->json();

        // Normalisasi + formatting
        $date = isset($p['date']) ? Carbon::parse($p['date']) : now();
    
        $receipt = [
            'id'           => $p['id'] ?? $id,
            'student_name' => $p['student_name'] ?? '-',
            'student_nis'  => $p['student_nis'] ?? '-',
            'course_name'  => $p['course_name'] ?? '-',
            'type'  => $p['type'] ?? '-',
            'payment_month' => $p['payment_month'] ?? '-',
            'amount'       => (int) ($p['amount'] ?? 0),
            'date'         => $p['date'],
            'time'      => $p['time'],
            'receipt_no'   => sprintf('KWT-%s-%s', $date->format('Ymd'), str_pad($p['id'] ?? $id, 4, '0', STR_PAD_LEFT)),
            'admin' => $p['admin']
        ];

    //    dd($receipt);
        
 

        $pdf = PDF::loadView('pages.payment.kwitansi-payment', compact('receipt'))
                  ->setPaper('A6', 'portrait'); // kecil & hemat kertas

        return $pdf->stream('kwitansi-'.$receipt['receipt_no'].'.pdf');
    }


    public function getUnpaidStudents()
    {
       // Base URL API diambil dari .env
        $base = env('API_BASE_URL', 'http://localhost:8000/api/v1');

        // Endpoint backend yang kamu sudah buat
        $endpoint = "{$base}/getUnpaidStudents";

        // Kirim request ke backend API
        $res = Http::acceptJson()->get($endpoint);

        // Jika gagal responsenya
        if (!$res->ok()) {
            abort(502, 'Gagal mengambil data murid yang belum bayar dari API.');
        }

        // Ambil data JSON dari response
        $data = $res->json();

        // Tampilkan ke view (atau bisa juga return response()->json($data))
        return view('pages.students.unpaid', [
            'students' => $data['data'] ?? [],
            'activeRoute' => 'getUnpaidStudents',
            'count' => $data['count'] ?? 0,
            'months' => $data['unpaid_months'] ?? [],
            'year' => $data['year'] ?? now()->year,
        ]);
    }
  

}