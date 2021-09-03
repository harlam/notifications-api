<?php

namespace App\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationException extends RuntimeException
{
    protected ?ConstraintViolationListInterface $violationList = null;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function setValidationError(ConstraintViolationListInterface $violationList): self
    {
        $this->violationList = $violationList;
        return $this;
    }

    public function getValidationError(): ?ConstraintViolationListInterface
    {
        return $this->violationList;
    }

    public static function create(ConstraintViolationListInterface $violationList, $message = "", $code = 0, Throwable $previous = null): self
    {
        return (new self($message, $code, $previous))
            ->setValidationError($violationList);
    }
}