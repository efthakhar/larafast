<?php

namespace Larafast\Core\Controllers;

use App\Http\Controllers\Controller;
use Larafast\Core\Services\RegisterPluginsService;

class SystemController extends Controller
{
    /*
    * Register active plugins service providers by scanning them from Plugins directory
    *
    */
    public function activatePlugins()
    {
        (new RegisterPluginsService)->register();
    }
}
