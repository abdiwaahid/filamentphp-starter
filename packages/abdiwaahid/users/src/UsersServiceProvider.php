<?php

namespace Abdiwaahid\Users;

use Abdiwaahid\Users\Observers\ActivityObserver;
use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\ActivityLogStatus;
use Abdiwaahid\Users\Http\Middleware\LanguageSwitcherMiddleware;

class UsersServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'abdiwaahid-users');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'abdiwaahid-users');
        
        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/abdiwaahid-users'),
        ]);
    }

    public function boot()
    {
        $resources = collect(Filament::getPanels())->flatMap(function ($panel) {
            return $panel->getResources();
        })->unique()->filter(function ($resource) {
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
