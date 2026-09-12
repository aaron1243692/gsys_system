<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeparatePortalAccess
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('configuration/*', 'academic/*', 'report', 'report/*', 'dashboard')) {
            foreach (['teacher', 'student', 'guardian'] as $guard) {
                abort_if(Auth::guard($guard)->check(), 403);
            }
        }

        return $next($request);
    }
}
