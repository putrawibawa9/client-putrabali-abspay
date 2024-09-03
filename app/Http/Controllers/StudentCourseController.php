<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index(){
          // Create a new Guzzle client
    $client = new Client();

    // Define the API endpoint URL
    $url = 'localhost:8000/api/v1/courses-available';

    try {
        // Send a GET request to the API
        $response = $client->request('GET', $url);

        // Check if the response status code is 200 (OK)
        if ($response->getStatusCode() === 200) {
            // Decode the JSON response into an associative array
            $data = json_decode($response->getBody()->getContents(), true);

            // Return or process the data as needed
            return view('student-courses.index', ['courses' => $data]);
        }
    } catch (\Exception $e) {
        // Handle exceptions or errors
        return response()->json([
            'error' => 'Failed to fetch data',
            'message' => $e->getMessage()
        ], 500);
    }
        
    }

  public function show($alias)
{
    // Create a new Guzzle client
    $client = new Client();

    // Define the API endpoint URLs
    $coursesUrl = 'http://localhost:8000/api/v1/courses-available';
    $courseWithStudentsUrl = 'http://localhost:8000/api/v1/courses-available/' . $alias;

    try {
        // Send GET requests to both APIs
        $courseResponse = $client->request('GET', $coursesUrl);
        $courseWithStudentsResponse = $client->request('GET', $courseWithStudentsUrl);

        // Check if both responses are successful
        if ($courseResponse->getStatusCode() === 200 && $courseWithStudentsResponse->getStatusCode() === 200) {
            // Decode the JSON responses into associative arrays
            $courses = json_decode($courseResponse->getBody()->getContents(), true);
            $courseWithStudents = json_decode($courseWithStudentsResponse->getBody()->getContents(), true);

            // Return the view with both data sets
            return view('student-courses.index', [
                'courses' => $courses,
                'courseWithStudents' => $courseWithStudents
            ]);
        }
    } catch (\Exception $e) {
        // Handle exceptions or errors
        return response()->json([
            'error' => 'Failed to fetch data',
            'message' => $e->getMessage()
        ], 500);
    }
}

}
