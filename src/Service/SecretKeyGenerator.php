<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\SecretKeyGeneratorInterface;
use Exception;

final class SecretKeyGenerator implements SecretKeyGeneratorInterface
{
    /**
     * @throws Exception
     */
    public function generate(): string
    {
        $result = hash('sha256', random_bytes(512));

        if (is_string($result)) {
            return $result;
        }

        throw new Exception('Generation failed');
    }
}
