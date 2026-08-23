<?php

namespace App\Modules\Http\Router\Reflection;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Route {
    public function __construct(public string $path) {
        $this->path = $path;
    }
}