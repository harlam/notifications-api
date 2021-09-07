<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends AppException
{
    protected ?ConstraintViolationListInterface $violationList = null;

    protected ?array $violationArray = null;

    public function setViolations(ConstraintViolationListInterface $violationList): self
    {
        $this->violationList = $violationList;
        return $this;
    }

    public function getViolations(): ?ConstraintViolationListInterface
    {
        return $this->violationList;
    }

    public function getViolationsAsArray(): array
    {
        if (null === $this->violationArray) {
            $this->violationArray = $this->violationsToArray($this->violationList);
        }

        return $this->violationArray;
    }

    protected function violationsToArray(?ConstraintViolationListInterface $violations): array
    {
        if (null === $violations) {
            return [];
        }

        $messages = [];

        /** @var ConstraintViolationInterface $constraint */
        foreach ($violations as $constraint) {
            $messages[$constraint->getPropertyPath()][] = $constraint->getMessage();
        }

        return $messages;
    }
}
