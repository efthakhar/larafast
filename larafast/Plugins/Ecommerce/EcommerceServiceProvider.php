<?php

namespace Larafast\Plugins\Ecommerce;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class EcommerceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'ecommerce');

    }

    public function register()
    {
        Storage::extend('ecommerce', function ($app, $config) {
            return Storage::createLocalDriver([
                'root' => base_path('larafast/Plugins/Ecommerce/Public'),
                'url' => env('APP_URL').'/ecommerce',
            ]);
        });
    }
}
