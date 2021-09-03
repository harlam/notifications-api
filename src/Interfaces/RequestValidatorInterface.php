<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Exception\RequestValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface RequestValidatorInterface
{
    public function getValidator(): ValidatorInterface;

    /**
     * @throws RequestValidationException
     */
    public function assertValid(object $object, $constraints = null, $groups = null): void;
}
