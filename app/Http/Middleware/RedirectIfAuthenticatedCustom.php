<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedCustom
{
    public function handle($request, Closure $next)
    {
        
        if (Auth::guard('admin')->check() || Auth::guard('superadmin')->check()) {
            return redirect()->route('dashboard');
        }


        return $next($request);
    }
}
