<?php
declare(strict_types=1);

namespace App\Notification\Fake;

use App\Exception\RequestValidationException;
use App\Service\AbstractService;

class FakeSender extends AbstractService implements FakeSenderInterface
{
    /**
     * @throws RequestValidationException
     */
    public function send(string $channel, FakeMessage $message): void
    {
        $this->assertValid($message);
    }
}
