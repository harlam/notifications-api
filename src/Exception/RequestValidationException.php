<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

class RequestValidationException extends ValidationException implements RequestExceptionInterface
{
}