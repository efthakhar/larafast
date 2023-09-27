<?php

namespace Larafast\Plugins\Ecommerce;

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

    }
}
