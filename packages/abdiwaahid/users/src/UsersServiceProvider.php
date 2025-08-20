<?php

namespace Abdiwaahid\Users;

use Abdiwaahid\Users\Observers\ActivityObserver;
use Filament\Facades\Filament;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\ActivityLogStatus;

class UsersServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'users');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/users'),
        ]);

        $resources = collect(Filament::getPanels())->flatMap(function ($panel){
            return $panel->getResources();
        })->unique()->filter(function($resource) {
            return !in_array($resource, [
                \Abdiwaahid\Users\Filament\Resources\Activities\ActivityResource::class,
            ]);
        });
        foreach ($resources as $resource) {
            $resource::getModel()::observe(ActivityObserver::class);
        }

        Event::listen(Login::class, function ($event) {
            app(ActivityLogger::class)
            ->useLog('Access')
            ->setLogStatus(app(ActivityLogStatus::class))
            ->withProperties([
                'attributes' => [
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ],
            ])
            ->event('Login')
            ->by($event->user)
            ->on($event->user)
            ->log('Login');
        });
    }
    
}
