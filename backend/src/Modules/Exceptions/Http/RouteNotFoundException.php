<?php

namespace App\Modules\Exceptions\Http;

use Throwable;
use Override;
use Workerman\Protocols\Http\Request;

class RouteNotFoundException extends HttpException {
    
    #[Override]
    public function __construct(Request $request, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($request, $message, $code, $previous);
    }

    public function getInvalidRoute() {
        return $this->getRequest()->path();
    }

}