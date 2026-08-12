<?php

namespace DI;

use Closure;
use InvalidArgumentException;
use LogicException;

class Container {

    protected $registrations = [];
    protected $singletons = [];
    protected $resolving = [];

    public function registrate(string $class, Closure $factory) {
        $this->isClassOrInterfaceExists($class);

        if (!is_callable($factory)) {
            throw new InvalidArgumentException("Provided closure isn't callable");
        }

        if ($this->registrations[$class] !== null) {
            throw new LogicException("Provided class has already been registered");
        }
        $this->registrations[$class] = $factory;
    }

    public function get(string $class) {
        $this->isClassOrInterfaceExists($class);

        if ($this->resolving[$class]) {
            throw new LogicException("Circular dependency detected: " .  implode(' => ', array_keys($this->resolving)));
        }

        $factory = $this->registrations[$class] ?? null;

        if ($factory === null) {
            throw new InvalidArgumentException("No provided registered class in container");
        }
        
        $this->resolving[$class] = true;

        try {
            return $factory($this);
        } finally {
            unset($this->resolving[$class]);
        }
    }

    public function singleton(string $class) {
        $this->isClassOrInterfaceExists($class);

        $instance = $this->singletons[$class] ?? null;
        $factory = $this->registrations[$class] ?? null;

        if ($factory === null) {
            throw new InvalidArgumentException("No provided registered class in container");
        }

        if ($instance === null) {
            $instance = $factory($this);
            $this->singletons[$class] = $instance;
        }

        return $instance;
    }

    private function isClassOrInterfaceExists(string $class) {
        if (!class_exists($class) && !interface_exists($class)) {
            throw new InvalidArgumentException("Provided class or interface does't exists");
        }
    }
}
