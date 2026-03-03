<?php

namespace App\Http\Controllers;

use App\Services\TeacherService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Log;

class TeacherController extends Controller
{
    protected $teacherService;

     public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request){
   $page = $request->query('page', 1);
   
        $teachers = $this->teacherService->getAllTeachers($page);
        $activeRoute = 'teachers';
        return view('pages.teachers.index', compact('teachers', 'activeRoute'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'alias' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
            $error = $this->teacherService->addNewTeacher($validatedData);
        if ($error) {
            return redirect('/teachers')->with('error', $error['message']);
        }

        return redirect('/teachers')->with('success', 'Teacher added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
  public function update(Request $request, $id)
{
    // Ambil data lama (pastikan bentuknya array)
    $old = $this->teacherService->getTeacherByID($id);
    if (is_object($old)) {
        $old = (array) $old;
    }

    // Hanya ambil field yang relevan dari form
    $input = $request->only(['name', 'username', 'alias', 'instagram', 'password', 'password_confirmation']);

    // Normalizer sederhana untuk string
    $normalize = function ($v) {
        return is_string($v) ? trim($v) : $v;
    };

    $updated = [];

    // Bandingkan field non-password
    foreach (['name', 'username', 'alias', 'instagram'] as $key) {
        if ($request->has($key)) {
            $newVal = $normalize($input[$key]);
            $oldVal = $normalize($old[$key] ?? null);

            // Kalau dikirim tapi kosong total, biarkan backend yang menilai (atau skip jika mau)
            // Di sini kita hanya kirim kalau benar-benar berbeda & tidak identik
            if ($newVal !== $oldVal) {
                // Jika mau cegah empty string terkirim, uncomment baris berikut:
                // if ($newVal === '' || $newVal === null) continue;
                $updated[$key] = $newVal;
            }
        }
    }

    // Bandingkan password: kirim hanya jika diisi dan berbeda dari yang lama
    if ($request->filled('password')) {
        $plain = (string) $input['password'];
        $oldHashed = $old['password'] ?? null;

        // Jika lama tersedia dan sama (cek dengan Hash::check), jangan kirim
        $sameAsOld = $oldHashed ? Hash::check($plain, $oldHashed) : false;

        if (!$sameAsOld) {
            // KIRIM PLAIN ke API; biarkan backend yang melakukan hash
            $updated['password'] = $plain;

            // Jika backend minta confirmed
            if ($request->has('password_confirmation')) {
                $updated['password_confirmation'] = (string) $input['password_confirmation'];
            }
        }
    }

    // Tidak ada perubahan
    if (empty($updated)) {
        return redirect('/teachers')->with('info', 'Tidak ada perubahan.');
    }

    // Panggil service untuk update
    $error = $this->teacherService->updateTeacher($id, $updated) ?? null;

    if ($error) {
        return redirect('/teachers')->with('error', $error['message'] ?? 'Gagal memperbarui data guru.');
    }

    return redirect('/teachers')->with('success', 'Teacher updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
     $this->teacherService->deleteTeacher($id);   
        return redirect('/teachers')->with('success', 'Teacher deleted successfully');
    }

    public function searchTeacherByNameOrAlias(Request $request)
{
    $page = $request->query('page', 1);
    $search = $request->input('search');
    $teachers = $this->teacherService->searchTeacherByNameOrAlias($search, $page);
  
    $activeRoute = 'teachers';
       return view('pages.teachers.index', compact('teachers', 'search', 'activeRoute'));

}

public function recapTeacherAbsences(Request $request)
{
    $activeRoute = 'recap-teacher-absences';

    // =============================
    // 1️⃣ Normalize Month & Year
    // =============================

    $monthInput = $request->input('month'); // format: 2026-03

    if ($monthInput) {
        $carbonDate = \Carbon\Carbon::createFromFormat('Y-m', $monthInput);
        $filterMonth = $carbonDate->month;
        $filterYear  = $carbonDate->year;
    } else {
        $filterMonth = now()->month;
        $filterYear  = now()->year;
    }

    // =============================
    // 2️⃣ Get Teacher Recap Data
    // =============================

    $teacher = $this->teacherService->recapTeacherAbsences([
        'id'    => $request->input('id'),
        'month' => $monthInput,
    ]);

    if (isset($teacher['error'])) {
        return redirect()->back()->with('error', $teacher['error']);
    }

    // =============================
    // 3️⃣ Call Backend API (Repost)
    // =============================

    $repostData  = [];
    $repostCount = 0;
    $proofs      = [];

    try {

        $teacherId = $request->input('id');
        $baseUrl   = config('services.api.base_url');

        $response = Http::get("{$baseUrl}/repost-proofs/{$teacherId}", [
            'month' => $filterMonth,
            'year'  => $filterYear,
        ]);

        if ($response->successful()) {
            $repostData  = $response->json();
            $repostCount = $repostData['count'] ?? 0;
            $proofs      = $repostData['proofs'] ?? [];
        }

    } catch (\Exception $e) {
        // Optional: log error
        Log::error('Repost API error: ' . $e->getMessage());
    }

    // =============================
    // 4️⃣ Return Clean Data to View
    // =============================

    return view('pages.recap-teacher-absences.show', compact(
        'activeRoute',
        'teacher',
        'repostCount',
        'proofs',
        'filterMonth',
        'filterYear'
    ));
}
}
