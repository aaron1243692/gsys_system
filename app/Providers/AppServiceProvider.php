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
        \Illuminate\Support\Facades\Gate::define('view-grades', function (\App\Models\User $user): bool {
            return $user->hasAnyRole(config('grading.report_roles'))
                || $user->getAllPermissions()->contains('codename', config('grading.report_permission'));
        });
    }
}
