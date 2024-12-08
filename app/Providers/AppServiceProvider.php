<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SmartCardReader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(SmartCardReader::class, function ($app) {
            return new SmartCardReader();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
