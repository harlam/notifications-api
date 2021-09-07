<?php

namespace App\Exception;

use App\Interfaces\ClientExceptionInterface;
use Throwable;

class RequestValidationException extends ValidationException implements ClientExceptionInterface
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}