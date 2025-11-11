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
    public function index()
    {
        // dd('masuk sini');

        // dd($this->apiBaseUrl);
        $response = Http::get($this->apiBaseUrl . '/course-prices');
// dd($response);
        if ($response->failed()) {
            return back()->withErrors(['error' => 'Gagal mengambil data dari server backend.']);
        }

        $coursePrices = $response->json();

        return view('course_prices.index', compact('coursePrices'));
    }

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
}
