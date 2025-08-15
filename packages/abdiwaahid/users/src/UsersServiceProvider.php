<?php

namespace Abdiwaahid\Users;

use Abdiwaahid\Users\Observers\ActivityObserver;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
    }
    
}
