<?php
declare(strict_types=1);

namespace App\Service;

use App\Exception\RequestValidationException;
use App\Interfaces\ValidatorAwareInterface;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractService implements ValidatorAwareInterface
{
    protected ?ValidatorInterface $validator = null;

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    public function getValidator(): ?ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * @throws RequestValidationException
     * @throws Exception
     */
    public function assertValid(object $object, $constraints = null, $groups = null): void
    {
        if (null === $this->getValidator()) {
            throw new Exception('Validator is not initialized');
        }

        $errors = $this->getValidator()->validate($object, $constraints, $groups);

        if (count($errors) > 0) {
            throw RequestValidationException::create($errors, 'Request validation error');
        }
    }
}
