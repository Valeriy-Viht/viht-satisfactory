<?php

namespace App\Modules\Exceptions\Http;

use App\Modules\Exceptions\AppException;
use Throwable;
use Override;
use Psr\Http\Message\RequestInterface;

class RouteNotFoundException extends HttpException {
    
    #[Override]
    public function __construct(RequestInterface $request, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($request, $message, $code, $previous);
    }

    public function getInvalidRoute() {
        return $this->getRequest()->getUri()->getPath();
    }

}