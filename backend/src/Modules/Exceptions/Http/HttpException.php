<?php


namespace App\Modules\Exceptions\Http;

use App\Modules\Exceptions\AppException;
use Throwable;
use Override;
use Workerman\Protocols\Http\Request;

class HttpException extends AppException {

    private Request $request;

    #[Override]
    public function __construct(Request $request, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->request = $request;
        parent::__construct($message, $code, $previous);
    }

    public function getRequest(): Request {
        return $this->request;
    }
}