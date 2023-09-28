<?php

namespace Larafast\Core;

use Illuminate\Support\ServiceProvider;

class LarafastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'larafast');

        $this->registerPlugins();
    }

    public function register()
    {
    }

    private function registerPlugins() {
$this->app->register(\Larafast\Plugins\Ecommerce\EcommerceServiceProvider::class);
}
}
