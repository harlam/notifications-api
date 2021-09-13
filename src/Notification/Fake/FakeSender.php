<?php

namespace App\Notification\Fake;

use App\Notification\AbstractSenderService;
use Notification\Common\SenderInterface;
use Notification\Fake\FakeMessage;
use Notification\Fake\FakeSenderConfiguration;

final class FakeSender extends AbstractSenderService implements FakeSenderServiceInterface
{
    protected function getSupportedMessages(): array
    {
        return [FakeMessage::class];
    }

    protected function getConfigurationClass(): string
    {
        return FakeSenderConfiguration::class;
    }

    protected function buildSender(): SenderInterface
    {
        /** @var FakeSenderConfiguration $configuration */
        $configuration = $this->getConfiguration();

        return new \Notification\Fake\FakeSender($configuration);
    }
}
