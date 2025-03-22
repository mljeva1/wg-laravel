<?php

namespace App\Providers;

use App\Services\Socialite\WargamingProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

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
    public function boot()
    {
        Socialite::extend('wargaming', function ($app) {
            $config = $app['config']['services.wargaming'];
            return new WargamingProvider(
                $app['request'],
                $config['application_id'],
                '', // Prazan string za client_secret jer Wargaming ne koristi client_secret
                $config['redirect']
            );
        });
    }
}
