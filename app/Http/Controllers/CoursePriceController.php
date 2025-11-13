<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CoursePriceController extends Controller
{
     protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('services.api.base_url');
    }

    // 🟩 READ - tampilkan semua harga kursus
    public function index($course_id, $year)
    {
        // dd('masuk sini');

        // dd($this->apiBaseUrl);
        $response = Http::get($this->apiBaseUrl . '/course-prices/year/' . $course_id . '/' . $year);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Gagal mengambil data dari server backend.']);
        }

        $course = $response->json();
        $activeRoute = 'courses';
// dd($course);
        return view('course_prices.yearly', compact('course', 'activeRoute'));
    }

    // public function showYearly($course_id, $year)
    // {
    //     $response = Http::get("{$this->backendBaseUrl}/payments/year/{$course_id}/{$year}");

    //     if ($response->failed()) {
    //         abort(404, 'Data tidak ditemukan atau gagal mengambil dari backend.');
    //     }

    //     $course = $response->json();
    //     return view('payments.yearly', compact('course'));
    // }

    // 🟦 CREATE - tambah data baru
    public function store(Request $request)
    {
        // dd('masuk sini');
        // dd( $request->all());
        $validated = $request->validate([
            'course_id' => 'required|integer',
            'year' => 'required|integer|min:2000',
            'month' => 'required|integer|min:1|max:12',
            'price' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ]);
// dd($validated);
        $response = Http::post($this->apiBaseUrl . '/course-prices', $validated);
// dd($response);
        if ($response->failed()) {
            return back()->withErrors(['error' => 'Gagal menyimpan data ke server backend.']);
        }

        return redirect()->route('course-prices.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // 🟨 UPDATE - ubah data harga
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ]);

        $response = Http::put($this->apiBaseUrl . '/course-prices/' . $id, $validated);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Gagal memperbarui data.']);
        }

        return redirect()->route('course-prices.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function updateMonth(Request $request)
{
    $validated = $request->validate([
        'course_id' => 'required|integer',
        'year' => 'required|integer',
        'month' => 'required|integer|min:1|max:12',
        'payment_amount' => 'required|numeric|min:0',
        'note' => 'nullable|string|max:255',
    ]);

    $response = Http::post("{$this->apiBaseUrl}/course-prices/set-monthly", [
        'course_id' => $validated['course_id'],
        'year' => $validated['year'],
        'month' => $validated['month'],
        'price' => $validated['payment_amount'],
        'note' => $validated['note'] ?? 'Update manual dari frontend',
    ]);

    if ($response->failed()) {
        return back()->withErrors(['error' => 'Gagal memperbarui data di backend.']);
    }

    return back()->with('success', 'Harga dan catatan bulan ' . $validated['month'] . ' berhasil diperbarui.');
}


public function showForTeacher($course_id, $year)
{
    $response = Http::get("{$this->apiBaseUrl}/course-prices/year/{$course_id}/{$year}");

    if ($response->failed()) {
        abort(404, 'Data tidak ditemukan.');
    }

    $course = $response->json();
    $activeRoute = 'payments';   
    return view('course_prices.yearly_for_teacher', compact('course', 'activeRoute'));
}

}
