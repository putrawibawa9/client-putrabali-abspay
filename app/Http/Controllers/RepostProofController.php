<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RepostProofController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('services.api.base_url');
    }

    /**
     * GET /repost-proofs
     * Tampilkan semua repost guru (opsional: bisa filter teacher_id)
     */
    public function index(Request $request)
    {
        $teacherId = $request->query('teacher_id');
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        try {
            $url = "{$this->apiBaseUrl}/repost-proofs";
            $response = Http::get($url, [
                'teacher_id' => $teacherId,
                'month' => $month,
                'year' => $year,
            ]);

            $data = $response->json();

            return view('pages.reposts.index', compact('data', 'teacherId', 'month', 'year'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    /**
     * GET /repost-proofs/create
     * Form upload repost
     */
    public function create()
    {
        
        $activeRoute = 'repost-proofs';
        return view('pages.reposts.create', compact('activeRoute'));
    }

    /**
     * POST /repost-proofs
     * Upload bukti repost baru
     */
   public function store(Request $request)
{
   
    // 🔹 Validasi frontend sebelum kirim ke backend
   



    try {
        // 🔹 Kirim file ke backend via API
        $response = Http::attach(
            'proof',
            file_get_contents($request->file('proof')->getRealPath()),
            $request->file('proof')->getClientOriginalName()
        )->post("{$this->apiBaseUrl}/repost-proofs", [
            'teacher_id' => $request->input('teacher_id'),
        ]);


        // 🔍 Cek status response
        $status = $response->status();
        $body = $response->json();
        // dd($status);
        // ✅ Jika upload berhasil
        if ($response->successful() && isset($body['success']) && $body['success'] === true) {
            return redirect()->back()
                ->with('success', $body['message'] ?? 'Bukti repost berhasil diupload!');
        }

        // ⚠️ Jika validasi backend gagal (422)
        if ($status === 422) {
            $errors = $body['errors'] ?? [];
            $errorMessage = collect($errors)->flatten()->join(', ');
            return back()->with('error', $errorMessage ?: 'Validasi gagal. Periksa kembali file Anda.');
        }

        // ❌ Jika gagal selain validasi
        $errorMessage = $body['message'] ?? 'Upload gagal. Silakan coba lagi.';
        return back()->with('error', $errorMessage);

    } catch (\Exception $e) {
        // 💥 Tangani error dari sisi frontend (misalnya koneksi ke API gagal)
        return back()->with('error', 'Terjadi kesalahan saat menghubungi server: ' . $e->getMessage());
    }
}


    /**
     * GET /repost-proofs/{teacher_id}
     * Menampilkan statistik dan daftar repost guru
     */
    public function show($teacher_id)
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);

        try {
            $response = Http::get("{$this->apiBaseUrl}/repost-proofs/{$teacher_id}", [
                'month' => $month,
                'year' => $year,
            ]);

            if ($response->successful()) {
                $activeRoute = 'repost-proofs';
                $data = $response->json();
                return view('pages.reposts.show', compact('data', 'teacher_id', 'month', 'year', 'activeRoute'));
            }

            return back()->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: ' . $e->getMessage());
        }
    }
}
