<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AutoLogoutOnIdle
{
    public function handle($request, Closure $next)
    {
        $idleLimit = config('session.idle_timeout', 900); // default 15 menit (900 detik)
        $nowTs = now()->timestamp;

        if (Auth::check()) {
            $last = Session::get('last_activity_ts');

            // Cek idle timeout
            if ($last && ($nowTs - (int)$last) > $idleLimit) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Sesi berakhir karena tidak ada aktivitas. Silakan login kembali.');
            }

            // Perbarui timestamp setiap ada aktivitas
            Session::put('last_activity_ts', $nowTs);
        }

        return $next($request);
    }
}
