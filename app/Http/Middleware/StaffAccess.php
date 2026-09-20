<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StaffAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user('web');
        if (!$user) return $next($request); // The route's auth middleware redirects guests.
        abort_unless($user->status === 'ACTIVE', 403);
        $name = $request->route()?->getName() ?? '';
        $ability = match (true) {
            str_starts_with($name, 'configuration.accounts.'),
            str_starts_with($name, 'academic.students.') => 'manage-registrations',
            str_starts_with($name, 'configuration.curriculum.'),
            str_starts_with($name, 'academic.schedule-load.') => 'manage-loads',
            str_starts_with($name, 'configuration.grade-encoding-schedule') => 'manage-schedules',
            str_starts_with($name, 'report.grades.approval') => 'approve-grades',
            str_starts_with($name, 'report.') => 'view-grades',
            default => null,
        };
        if (str_starts_with($name, 'configuration.setting.')) {
            abort_unless($user->hasRole('admin'), 403);
        }
        if ($ability) Gate::forUser($user)->authorize($ability);
        return $next($request);
    }
}
