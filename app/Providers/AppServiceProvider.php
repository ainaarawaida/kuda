<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        FilamentView::registerRenderHook(
            'panels::head.start',
            fn (): string => '<meta name="robots" content="noindex,nofollow">'
        );

        $this->app->singleton(
            LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
