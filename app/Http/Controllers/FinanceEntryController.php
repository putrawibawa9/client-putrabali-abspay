<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FinanceEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil filter tanggal dari query string
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Kirim ke API jika ada filter, jika tidak kirim kosong
        $query = [];
        if ($startDate) {
            $query['start_date'] = $startDate;
        }
        if ($endDate) {
            $query['end_date'] = $endDate;
        }

        $response = Http::get(env('API_BASE_URL') . '/finance-entries', $query);
        $financeCategory = $response->successful() ? $response->json() : [];

        $activeRoute = 'finance-entries';
// dd($financeCategory);
        return view('pages.finance-entries.index', compact('financeCategory', 'activeRoute', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'finance_category_id' => ['required', 'integer'],
            'direction' => ['required', 'in:expense,income'],
            'item_name' => ['required', 'string', 'max:255'],
            'unit_price' => ['required', 'integer', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $data = [
            'finance_category_id' => (int) $validated['finance_category_id'],
            'direction' => $validated['direction'],
            'item_name' => $validated['item_name'],
            'unit_price' => (int) $validated['unit_price'],
            'quantity' => (int) $validated['quantity'],
            'note' => $validated['note'] ?? null,
        ];

        $response = Http::post(env('API_BASE_URL') . '/finance-entries', $data);

        if ($response->successful()) {
            return redirect()->route('finance-categories')->with('success', 'Finance entry added successfully.');
        } else {
            return redirect()->route('finance-categories')->with('error', 'Failed to add finance entry.');
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = Http::delete(env('API_BASE_URL') . '/finance-entries/' . $id);

        if ($response->successful()) {
            $payload = $response->json();

            return redirect()
                ->route('finance-categories')
                ->with('success', $payload['message'] ?? 'Finance entry deleted successfully.');
        }

        $payload = $response->json();

        return redirect()
            ->route('finance-categories')
            ->with('error', $payload['message'] ?? 'Failed to delete finance entry.');
    }
}
