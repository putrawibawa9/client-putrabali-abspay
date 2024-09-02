<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
public function index(){
          // Create a new Guzzle client
    $client = new Client();

    // Define the API endpoint URL
    $url = 'localhost:8000/api/v1/enrollments';

    try {
        // Send a GET request to the API
        $response = $client->request('GET', $url);

        // Check if the response status code is 200 (OK)
        if ($response->getStatusCode() === 200) {
            // Decode the JSON response into an associative array
            $data = json_decode($response->getBody()->getContents(), true);

            // Return or process the data as needed
            return view('enrollments.enrollments', ['data' => $data]);
        }
    } catch (\Exception $e) {
        // Handle exceptions or errors
        return response()->json([
            'error' => 'Failed to fetch data',
            'message' => $e->getMessage()
        ], 500);
    }
        
    }

     public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'student_id' => 'required',
            'course_id' => 'required',
            'custom_payment_rate' => 'required',
        ]);

        // Initialize Guzzle client
        $client = new Client();

        try {
            // Send POST request to the API endpoint
            $response = $client->post('localhost:8000/api/v1/enrollments', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $validatedData,
            ]);

            // Decode the JSON response
            $data = json_decode($response->getBody(), true);

            // Handle the response as needed
            return redirect()->route('students.index');

        } catch (\Exception $e) {
            // Handle exceptions or errors
            return response()->json([
                'error' => 'Failed to enroll student',
            ], 500);
        }
    }
}
