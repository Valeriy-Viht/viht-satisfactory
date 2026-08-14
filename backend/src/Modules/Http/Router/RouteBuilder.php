<?php

namespace App\Modules\Http\Router;

use App\Modules\Http\Contracts\IController;
use App\Modules\Http\Contracts\IMiddleware;
use App\Utils\TypeAssert;

class RouteBuilder {

    private string $path;

    private string $controller;

    private $middlewares = [];

    public function __construct(string $path, string $controller)
    {
        TypeAssert::isSubClassOf($controller, IController::class);

        $this->path = $path;
        $this->controller = $controller;
    }

    public function path(string $path) {
        $this->path = $path;
        return $this;
    }

    public function controller(string $controller) {
        TypeAssert::exists($controller);
        TypeAssert::isSubClassOf($controller, IController::class);
        $this->controller = $controller;
        return $this;
    }

    public function middlewares(array $middlewares) {
        foreach ($middlewares as $middleware) {
            TypeAssert::exists($middleware);
            TypeAssert::isSubClassOf($middleware, IMiddleware::class);
        }
        $this->middlewares = $middlewares;
        return $this;
    }

    public function addMiddleware(string $middleware) {
        TypeAssert::exists($middleware);
        TypeAssert::isSubClassOf($middleware, IMiddleware::class);
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function build() {
        return new Route($this->path, $this->controller, $this->middlewares);
    }
}