<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\NotificationChannel;
use App\Notification\AbstractNotificationResult;
use Symfony\Contracts\EventDispatcher\Event;

final class NotificationMessageSentEvent extends Event
{
    protected NotificationChannel $notificationChannel;

    protected object $message;

    protected AbstractNotificationResult $notificationResult;

    public function __construct(NotificationChannel $notificationChannel, object $message, AbstractNotificationResult $notificationResult)
    {
        $this->notificationChannel = $notificationChannel;
        $this->message = $message;
        $this->notificationResult = $notificationResult;
    }

    public function getNotificationChannel(): NotificationChannel
    {
        return $this->notificationChannel;
    }

    public function getMessage(): object
    {
        return $this->message;
    }

    public function getNotificationResult(): AbstractNotificationResult
    {
        return $this->notificationResult;
    }
}
