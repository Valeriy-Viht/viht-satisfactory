<?php


namespace App\Modules\Exceptions\Http;

use App\Modules\Exceptions\AppException;
use Throwable;
use Override;
use Psr\Http\Message\RequestInterface;

class HttpException extends AppException {

    private RequestInterface $request;

    #[Override]
    public function __construct(RequestInterface $request, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->request = $request;
        parent::__construct($message, $code, $previous);
    }

    public function getRequest(): RequestInterface {
        return $this->request;
    }
}