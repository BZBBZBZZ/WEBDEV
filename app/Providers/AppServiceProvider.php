<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\RajaOngkirService;
use App\Services\MidtransService; // ✅ IMPORT

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

        // ✅ MIDTRANS SERVICE
        $this->app->singleton(MidtransService::class, function ($app) {
            return new MidtransService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
