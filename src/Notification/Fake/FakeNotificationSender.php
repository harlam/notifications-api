<?php

declare(strict_types=1);

namespace App\Notification\Fake;

use App\Notification\AbstractNotificationSender;
use App\Notification\AbstractNotificationResult;
use App\Notification\BaseNotificationResult;

final class FakeNotificationSender extends AbstractNotificationSender
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
    protected function process(object $message, object $configuration): AbstractNotificationResult
    {
        return (new BaseNotificationResult(true))
            ->setDetailedMessage("processed success via sender: " . $configuration->getSender());
    }
}
