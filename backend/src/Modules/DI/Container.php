<?php

namespace App\Modules\DI;

use App\Utils\TypeAssert;
use Closure;
use InvalidArgumentException;
use LogicException;

class Container {

    protected $registrations = [];
    protected $singletons = [];
    protected $resolving = [];

    public function registrate(string $class, Closure $factory) {
        TypeAssert::exists($class);

        if (!is_callable($factory)) {
            throw new InvalidArgumentException("Provided closure isn't callable");
        }

        if ($this->registrations[$class] !== null) {
            throw new LogicException("Provided class has already been registered");
        }
        $this->registrations[$class] = $factory;
    }

    public function get(string $class) {
        TypeAssert::exists($class);

        if ($this->resolving[$class]) {
            throw new LogicException("Circular dependency detected: " .  implode(' => ', array_keys($this->resolving)));
        }

        $factory = $this->registrations[$class] ?? null;

        if ($factory === null) {
            throw new InvalidArgumentException("No provided registered type in container. Unknown type: " . $class);
        }
        
        $this->resolving[$class] = true;

        try {
            return $factory($this);
        } finally {
            unset($this->resolving[$class]);
        }
    }

    public function singleton(string $class) {
        TypeAssert::exists($class);

        $instance = $this->singletons[$class] ?? null;
        $factory = $this->registrations[$class] ?? null;

        if ($factory === null) {
            throw new InvalidArgumentException("No provided registered type in container. Unknown type: " . $class);
        }

        if ($instance === null) {
            $instance = $factory($this);
            $this->singletons[$class] = $instance;
        }

        return $instance;
    }
}
