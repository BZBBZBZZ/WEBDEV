<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use App\Services\RajaOngkirService;
use App\Services\MidtransService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RajaOngkirService::class, function ($app) {
            return new RajaOngkirService();
        });

        $this->app->singleton(MidtransService::class, function ($app) {
            return new MidtransService();
        });
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
