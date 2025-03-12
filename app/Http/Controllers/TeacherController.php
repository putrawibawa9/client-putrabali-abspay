<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\TeacherService;

class TeacherController extends Controller
{
    protected $teacherService;

     public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request){
   $page = $request->query('page', 1);
   
        $teachers = $this->teacherService->getAllTeachers($page);
        $activeRoute = 'teachers';
        return view('pages.teachers.index', compact('teachers', 'activeRoute'));
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
        // dd($request->all());
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'alias' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
            $error = $this->teacherService->addNewTeacher($validatedData);
        if ($error) {
            return redirect('/teachers')->with('error', $error['message']);
        }

        return redirect('/teachers')->with('success', 'Teacher added successfully');
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
     public function update(Request $request, $id)
{
    // dd($id);
    // implement the logic to compare the old data and new data
    $oldData = $this->teacherService->getTeacherByID($id);
    $newData = $request->all();

    // Initialize an array to store only the changed data
    $updatedData = [];

    // Compare each field in the new data with the old data
    foreach ($newData as $key => $value) {
        // Skip if the key is not present in the old data
        if (!array_key_exists($key, $oldData)) {
            continue;
        }

        // Compare the values and only add the changed ones
        if ($value != $oldData[$key]) {
            $updatedData[$key] = $value;
        }
    }
    // dd($updatedData);

     // Proceed with the next process only if there are changes
    if (!empty($updatedData)) {
       $error = $this->teacherService->updateTeacher($id, $updatedData);
    }

        if ($error) {
            return redirect('/teachers')->with('error', $error['message']);
        }
        return redirect('/teachers')->with('success', 'Teacher updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
     $this->teacherService->deleteTeacher($id);   
        return redirect('/teachers')->with('success', 'Teacher deleted successfully');
    }

    public function searchTeacherByNameOrAlias(Request $request)
{
    $page = $request->query('page', 1);
    $search = $request->input('search');
    $teachers = $this->teacherService->searchTeacherByNameOrAlias($search, $page);
  
    $activeRoute = 'teachers';
       return view('pages.teachers.index', compact('teachers', 'search', 'activeRoute'));

}
}
