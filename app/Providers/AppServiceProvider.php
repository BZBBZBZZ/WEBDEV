<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use App\Services\RajaOngkirService;
use App\Services\MidtransService;
use App\Services\FonnteService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // RajaOngkir Service
        $this->app->singleton(RajaOngkirService::class, function ($app) {
            return new RajaOngkirService();
        });

        // Midtrans Service
        $this->app->singleton(MidtransService::class, function ($app) {
            return new MidtransService();
        });

        // Fonnte Service
        $this->app->singleton(FonnteService::class, function ($app) {
            return new FonnteService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        
        // FORCE HTTPS UNTUK NGROK
        if (config('app.env') === 'production' || str_contains(config('app.url'), 'ngrok')) {
            URL::forceScheme('https');
        }
    }
}
