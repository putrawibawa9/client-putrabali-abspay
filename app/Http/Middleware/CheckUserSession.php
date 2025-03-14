<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckUserSession
{
    public function handle($request, Closure $next)
    {
            // Log::info('CheckUserSession middleware triggered.');
            // dd("CheckUserSession middleware triggered.");
        if (!Session::has('user_logged_in')) {
            // route back to / route
            return redirect()->route('login')->with('error', 'You need to login to access this page');
        }
        return $next($request);
    }
}
