<?php

namespace App\Modules\Http\Contracts;

use Psr\Http\Message\RequestInterface;

interface IMiddleware {
    public function process(RequestInterface $request);
}