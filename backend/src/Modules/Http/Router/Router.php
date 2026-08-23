<?php

namespace App\Modules\Http\Router;

use App\Modules\DI\Container;
use App\Modules\Exceptions\Http\MethodNotFoundException;
use App\Modules\Exceptions\Http\RouteNotFoundException;
use LogicException;
use Psr\Http\Message\RequestInterface;
use Workerman\Protocols\Http\Request;

class Router { 

    private $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bind(Route $route) {
        $path = $route->getPath();
        if (isset($this->routes[$path])) {
            throw new LogicException('Provided path (' . $path . ') has already been registered in Router');
        }
        $this->routes[$path] = $route;
    }

    public function resolve(Request $request) {
        $path = $request->path();
        $route = $this->routes[$path] ?? null;

        if ($route === null) {
            throw new RouteNotFoundException($request, 'Provided path doesn\'t registered in Router');
        }
        $controller = $route->getController();
        $middlewares = $route->getMiddlewares();

        if (count($middlewares) > 0) {
            foreach ($middlewares as $middleware) {
                $middleware = $this->container->singleton($middleware);
                $request = $middleware->process($request);
            }
        }

        $methodName = strtolower($request->method());

        if (!method_exists($controller, $methodName)) {
            throw new MethodNotFoundException($request, "Provided method doesn't exists in controller");
        }
        
        $instance = $this->container->get($controller);

        return $instance->$methodName($request);
    }

}