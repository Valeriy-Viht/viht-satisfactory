<?php

namespace App\Modules\DI;

use App\Utils\TypeAssert;
use ReflectionClass;

class DependencyResolver {
    
    public static function resolve(Container $c, string $baseClass) {

        $instances = [];
        $refClass = new ReflectionClass($baseClass);
        $constructor = $refClass->getConstructor();
        
        if (isset($constructor)) {
            $deps = $constructor->getParameters();
            foreach ($deps as $depClass) {
                $depClass = $depClass->getType()->getName();
                TypeAssert::exists($depClass);
                $instances[] = $c->get($depClass);
            }
        }
        

        return new $baseClass(...$instances);
    }
}