<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\NotificationChannel;
use Notification\Common\NotificationResultInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class MessageSentEvent extends Event
{
    protected NotificationChannel $notificationChannel;

    protected object $message;

    protected NotificationResultInterface $notificationResult;

    public function __construct(NotificationChannel $notificationChannel, object $message, NotificationResultInterface $notificationResult)
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

    public function getNotificationResult(): NotificationResultInterface
    {
        return $this->notificationResult;
    }
}
