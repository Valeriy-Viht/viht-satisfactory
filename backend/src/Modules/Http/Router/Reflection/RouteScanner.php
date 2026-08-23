<?php

namespace App\Modules\Http\Router\Reflection;

use App\Modules\DI\Container;
use App\Modules\Http\Router\Reflection\Route as RouteAttribute;
use App\Modules\Http\Router\Route;
use App\Modules\Http\Router\RouteBuilder;
use App\Modules\Http\Router\Router;
use App\Utils\TypeAssert;
use InvalidArgumentException;
use ReflectionClass;

class RouteScanner {

    public function __construct(private Container $container)
    {
        $this->container = $container;
    }

    public function scanRoutes(array $classes): Router {
        $router = new Router($this->container);

        foreach ($classes as $class) {
            TypeAssert::exists($class);
            $this->container->registrate($class);
            $router->bind($this->buildRoute($class));
        }

        return $router;
    }

    private function buildRoute(string $class): Route {
        TypeAssert::exists($class);

        $reflectionClass = new ReflectionClass($class);

        $routeAttribute = $reflectionClass->getAttributes(RouteAttribute::class)[0];
        $middlewareAttributes = $reflectionClass->getAttributes(Middleware::class);

        if(!isset($routeAttribute)) {
                throw new InvalidArgumentException("Provided class doesn't have Route attribute. Invalid class: " . $class);
        }
        
        $routeAttribute = $routeAttribute->newInstance();
        $path = $routeAttribute->path;

        if($path === "") {
            throw new InvalidArgumentException("Route attribute can't have an empty path. Invalid class: " . $class);
        }

        $builder = new RouteBuilder($path, $class);
        if(isset($middlewareAttributes)) {
            foreach ($middlewareAttributes as $middlewareAttribute) {
                $middlewareAttribute = $middlewareAttribute->newInstance();

                $this->container->registrate($middlewareAttribute->class);

                $builder->addMiddleware($middlewareAttribute->class);
            }
        }

        return $builder->build();
    }
}