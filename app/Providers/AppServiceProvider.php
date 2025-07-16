<?php

namespace App\Providers;

use App\Services\CategoryFilterService;
use App\Services\DateIntervalService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DateIntervalService::class, function (Application $app) {
            return new DateIntervalService($app['request']);
        });

        $this->app->singleton(CategoryFilterService::class, function (Application $app) {
            return new CategoryFilterService($app['request']);
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
