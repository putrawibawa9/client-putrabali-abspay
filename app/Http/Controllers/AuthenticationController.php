<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    protected $authenticationService;

      public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function loginPage(){
        return view('pages.authentications.login');
    }

    public function login(Request $request){
            // dd($request->all());
      $credentials =  $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

      if ($this->authenticationService->login($credentials) ) {
           // After successful login
Session::put('user_logged_in', true);
        // dd('login success');
        return redirect()->route('students.index');
      } 
       
            
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'name' => 'required'
        ]);
      
        $this->authenticationService->register($request->all());
    }

    public function logout()
{
    // Log out the user
    Auth::logout();

    // Clear all session data
    session()->flush();

    // Redirect to login page
    return redirect()->route('login');
}

}
