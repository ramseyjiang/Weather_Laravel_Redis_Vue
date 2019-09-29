<?php

namespace Weather\Providers;

use Illuminate\Support\ServiceProvider;
use Weather\Contracts\Services\WeatherServiceContract;
use Weather\Services\WeatherService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WeatherServiceContract::class, WeatherService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
