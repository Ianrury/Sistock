<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Issuperadmin
{
    public function handle($request, Closure $next)
    {
        
        if (Auth::guard('superadmin')->check()) {
            return redirect()->route('akun');
        }


        return $next($request);
    }
}
