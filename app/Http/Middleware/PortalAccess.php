<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalAccess
{
    public function handle(Request $request, Closure $next, string $portal)
    {
        if (! Auth::guard($portal)->check()) {
            foreach (['web', 'teacher', 'student', 'guardian'] as $guard) {
                abort_if(Auth::guard($guard)->check(), 403);
            }
            if ($request->expectsJson()) {
                abort(401);
            }

            return redirect()->route('portal.login', ['portal' => $portal]);
        }

        return $next($request);
    }
}
