<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        // PERBAIKAN: Gunakan && (AND) bukan || (OR)
        if (!Auth::guard('admin')->check() && !Auth::guard('superadmin')->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}