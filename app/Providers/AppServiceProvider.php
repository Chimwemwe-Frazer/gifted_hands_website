<?php

namespace App\Providers;

use App\Models\Appointment;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('layouts.navigation', function ($view): void {
            $view->with(
                'pendingAppointmentsCount',
                Appointment::where('status', Appointment::STATUS_PENDING)->count()
            );
        });
    }
}
