<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Routes API
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));

        // Routes Web
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

}
