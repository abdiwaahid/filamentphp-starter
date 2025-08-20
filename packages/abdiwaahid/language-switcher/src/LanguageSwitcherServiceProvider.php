<?php

namespace Abdiwaahid\LanguageSwitcher; 

use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class LanguageSwitcherServiceProvider extends ServiceProvider
{
    public function register()
    {
        Filament::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            fn() => $this->getLanguageSwitcherView(),
        );

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'abdiwaahid-language-switcher');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'abdiwaahid-language-switcher');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->mergeConfigFrom(__DIR__ . '/../config/abdiwaahid-language-switcher.php', 'abdiwaahid-language-switcher');
        
        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/abdiwaahid-language-switcher'),
        ]);
        $this->publishes([
            __DIR__ . '/../config/abdiwaahid-language-switcher.php' => config_path('abdiwaahid-language-switcher.php'),
        ]);
    }

    public function boot()
    {

    }

    protected function getLanguageSwitcherView()
    {
        $locale = Cache::get('locale', app()->getLocale());
        $languages = collect(config('abdiwaahid-language-switcher.languages'))->except($locale)->toArray();
        return view('abdiwaahid-language-switcher::language-switcher', compact('locale', 'languages'));
    }
}
