<?php
declare(strict_types=1);

namespace App\Interfaces;

use Symfony\Component\Validator\Validator\ValidatorInterface;

interface ValidatorAwareInterface
{
    public function setValidator(ValidatorInterface $validator): void;

    public function assertValid(object $object, $constraints = null, $groups = null): void;
}
