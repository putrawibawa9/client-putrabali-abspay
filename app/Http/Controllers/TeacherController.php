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
   public function index(){
        $teachers = $this->teacherService->getAllTeachers();
  
        return view('teachers.index', compact('teachers'));
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
        $this->teacherService->addNewTeacher($validatedData);
        return view('teachers.create');
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
     $this->teacherService->deleteTeacher($id);   
     return redirect('/teachers');
    }
}
