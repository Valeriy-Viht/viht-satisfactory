<?php

namespace App\Modules\Exceptions;

use Exception;
use Override;
use Throwable;

abstract class AppException extends Exception {

    #[Override]
    public function __construct(string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}