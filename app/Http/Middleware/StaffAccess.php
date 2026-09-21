<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\WebPermissions;

class StaffAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user('web');
        if (!$user) return $next($request); // The route's auth middleware redirects guests.
        abort_unless($user->status === 'ACTIVE', 403);
        if ($permission = WebPermissions::for($request)) {
            abort_unless($user->can($permission), 403);
        }
        return $next($request);
    }
}
