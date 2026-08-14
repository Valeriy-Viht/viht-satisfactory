<?php


namespace App\Modules\Http\Router;


class Route {
    private string $path;
    private string $controller;
    private $middlewares = [];

    public function __construct(string $path, string $controller, array $middlewares)
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->middlewares = $middlewares;
    }

    public function getPath() {
        return $this->path;
    }

    public function getController() {
        return $this->controller;
    }

    public function getMiddlewares() {
        return $this->middlewares;
    }
}