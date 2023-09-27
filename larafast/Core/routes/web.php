<?php

use Illuminate\Support\Facades\Route;
use Larafast\Core\Controllers\SystemController;

// Route::get('/hi', function () {
//     return 'lorem Hi';
// });

Route::get('/larafast/activate-plugins', [SystemController::class, 'activatePlugins']);
