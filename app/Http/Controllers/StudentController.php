<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class StudentController extends Controller
{
    protected $studentService;
     public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }
    /**
     * Display a listing of the resource.
     */
   public function index(){
        // use student service to get all students
         $students = $this->studentService->getAllStudents();
   
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'wa_number' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'enroll_date' => 'required|string|max:255',
        ]);
        $validatedData['wa_number'] = $this->formatWaNumber($validatedData['wa_number']);

        // Initialize Guzzle client
        $client = new Client();

        try {
            // Send POST request to the API endpoint
            $response = $client->post('localhost:8000/api/v1/students', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $validatedData,
            ]);

            // Decode the JSON response
            $data = json_decode($response->getBody(), true);

            // Handle the response as needed
            return redirect()->route('students.index')->with('success', $data['message']);

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

    protected function formatWaNumber($wa_number)
{
    if (substr($wa_number, 0, 1) === '0') {
        return '62' . substr($wa_number, 1);
    }
    return $wa_number;
}
}
