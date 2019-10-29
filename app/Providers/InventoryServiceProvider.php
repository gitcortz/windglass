<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Inventory\InventoryService;

class InventoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Library\Services\Inventory\InventoryServiceInterface', function ($app) {
            return new InventoryService();
        });
    }
}
