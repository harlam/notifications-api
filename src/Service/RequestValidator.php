<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\RequestValidationException;
use App\Interfaces\RequestValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RequestValidator implements RequestValidatorInterface
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * @throws RequestValidationException
     */
    public function assertValid(object $object, $constraints = null, $groups = null): void
    {
        $errors = $this->getValidator()->validate($object, $constraints, $groups);

        if (count($errors) > 0) {
            throw RequestValidationException::create($errors, 'Request validation error');
        }
    }
}
