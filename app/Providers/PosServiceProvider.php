<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Pos\PosService;

class PosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Library\Services\Pos\PosServiceInterface', function ($app) {
            return new PosService();
        });
    }
}
