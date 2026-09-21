<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::before(function (\App\Models\User $user): ?bool {
            return $user->status === 'ACTIVE' && $user->hasRole('admin') ? true : null;
        });
        \Illuminate\Support\Facades\View::composer('layouts.header', function ($view) {
            if (\Illuminate\Support\Facades\Auth::guard('web')->check() && ! array_key_exists('notifications', $view->getData())) {
                $view->with('notifications', app(\App\Services\AdminDashboardData::class)->headerNotifications());
            }
        });
        foreach (['manage-registrations'=>'accounts.review', 'manage-schedules'=>'grades.schedule', 'approve-grades'=>'grades.approve', 'manage-loads'=>'academic.load'] as $ability => $permission) {
            \Illuminate\Support\Facades\Gate::define($ability, fn (\App\Models\User $user) => $user->status === 'ACTIVE' && ($user->hasRole('admin') || $user->getAllPermissions()->contains('codename', $permission)));
        }
        \Illuminate\Support\Facades\Gate::define('view-grades', function (\App\Models\User $user): bool {
            return $user->hasAnyRole(config('grading.report_roles'))
                || $user->getAllPermissions()->contains('codename', config('grading.report_permission'));
        });
    }
}
