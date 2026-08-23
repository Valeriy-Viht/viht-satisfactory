<?php

use App\Controllers\HelloController;
use App\Modules\Http\Router\Reflection\RouteScanner;
use App\Modules\Http\Router\RouteBuilder;
use App\Modules\Http\Router\Router;

$scanner = new RouteScanner($c);
$router = $scanner->scanRoutes([
    HelloController::class
]);

// $router->bind((new RouteBuilder("/hello", HelloController::class))->build());