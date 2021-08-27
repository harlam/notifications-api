<?php
declare(strict_types=1);

namespace App\Notification\Fake;

interface FakeSenderInterface
{
    public function send(string $channel, FakeMessage $message): void;
}
