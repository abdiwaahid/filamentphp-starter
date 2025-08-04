<?php

namespace App\Providers;

use App\Policies\ActivityPolicy;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;

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
        Gate::policy(Activity::class, ActivityPolicy::class);

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch->locales(['ar', 'en', 'fr','es','de']);
        });
    }
}
