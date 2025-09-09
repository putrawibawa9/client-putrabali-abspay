<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FinanceCategoryController extends Controller
{
    public function index()
    {
        // Ambil data kategori keuangan dari API
        $response = Http::get(env('API_BASE_URL') . '/finance-entries-categories');
        $categories = $response->successful() ? $response->json() : [];
        $activeRoute = 'finance-categories';
        // dd($categories);
        return view('pages.finance-entries.categories', compact('categories', 'activeRoute'));
    }
}
