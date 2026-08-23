<?php

namespace App\Modules\Http\Router\Reflection;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Middleware {
    public function __construct(public string $class) {
        $this->class = $class;
    }
}