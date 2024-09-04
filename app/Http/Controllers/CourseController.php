<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\CourseService;

class CourseController extends Controller
{
     protected $courseService;
   public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    /**
     * Display a listing of the resource.
     */
 public function index(){
        $courses = $this->courseService->getAllCourses();
   
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'credit_units' => 'required|string|max:255',
        ]);

        // Create a new Guzzle client
        $client = new Client();

        // Define the API endpoint URL
        $url = 'localhost:8000/api/v1/courses';

        try {
            // Send a POST request to the API
            $response = $client->request('POST', $url, [
                'form_params' => $validatedData
            ]);

            // Check if the response status code is 201 (Created)
            if ($response->getStatusCode() === 201) {
                // Decode the JSON response into an associative array
                $data = json_decode($response->getBody()->getContents(), true);

                // Redirect to the course details page
                return redirect()->route('courses.index', ['course' => $data['id']]);
            }
        } catch (\Exception $e) {
            // Handle exceptions or errors
            return response()->json([
                'error' => 'Failed to create course',
                'message' => $e->getMessage()
            ], 500);
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
