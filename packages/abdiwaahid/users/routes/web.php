<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function(){
    Route::get('/abdiwaahid-language-switcher/{locale}', function ($locale) {
        app()->setLocale($locale);
        Cache::forever('locale_'.auth()->id(), $locale);
        return redirect()->back();
    })->name('abdiwaahid-language-switcher');
}); 
