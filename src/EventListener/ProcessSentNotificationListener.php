<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Event\NotificationMessageSentEvent;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;

class ProcessSentNotificationListener
{
    protected SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function __invoke(NotificationMessageSentEvent $event)
    {
        $this->log(
            sprintf(
                'Notification result: %s for message: %s via channel: %s' . PHP_EOL,
                $this->serializer->serialize($event->getNotificationResult(), 'json'),
                $this->serializer->serialize($event->getMessage(), 'json'),
                $event->getNotificationChannel()->getKey()
            )
        );
    }

    protected function log(string $message): void
    {
        throw new RuntimeException('Not implemented. Message: ' . $message);
    }
}