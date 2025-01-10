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
            // route back to login
            return redirect()->route('login');
        }
        return $next($request);
    }
}
