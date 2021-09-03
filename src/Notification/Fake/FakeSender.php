<?php

declare(strict_types=1);

namespace App\Notification\Fake;

use App\Notification\AbstractNotificationSender;

final class FakeSender extends AbstractNotificationSender
{
    protected function getMessageClass(): string
    {
        return FakeMessage::class;
    }

    protected function getConfigurationClass(): string
    {
        return FakeChannelConfiguration::class;
    }

    /**
     * @param object|FakeMessage $message
     * @param object|FakeChannelConfiguration $configuration
     */
    protected function process(object $message, object $configuration): void
    {
        var_dump('process message via sender: ' . $configuration->getSender());
        exit;
    }
}
