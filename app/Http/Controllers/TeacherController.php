<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(){
          // Create a new Guzzle client
    $client = new Client();

    // Define the API endpoint URL
    $url = 'localhost:8000/api/v1/teachers';

    try {
        // Send a GET request to the API
        $response = $client->request('GET', $url);

        // Check if the response status code is 200 (OK)
        if ($response->getStatusCode() === 200) {
            // Decode the JSON response into an associative array
            $data = json_decode($response->getBody()->getContents(), true);

            // Return or process the data as needed
            return view('teachers.index', ['teachers' => $data]);
        }
    } catch (\Exception $e) {
        // Handle exceptions or errors
        return response()->json([
            'error' => 'Failed to fetch data',
            'message' => $e->getMessage()
        ], 500);
    }
        
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'alias' => 'required|string|max:255',
        ]);

        // Initialize Guzzle client
        $client = new Client();

        try {
            // Send POST request to the API endpoint
            $response = $client->post('localhost:8000/api/v1/teachers', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $validatedData,
            ]);

            // Decode the JSON response
            $data = json_decode($response->getBody(), true);

            // Handle the response as needed
            return redirect()->route('teachers.index')->with('success', $data['message']);

        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->route('students.index')->withErrors('Failed to create student: ' . $e->getMessage());
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
        //
    }
}
