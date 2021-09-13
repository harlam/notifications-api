<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\NotificationLog;
use App\Event\MessageSentEvent;
use App\Exception\AppException;
use App\Repository\NotificationLogRepository;
use Doctrine\ORM\ORMException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class LogSentMessageListener
{
    protected NormalizerInterface $normalizer;
    protected NotificationLogRepository $notificationLogRepository;

    public function __construct(NormalizerInterface $normalizer, NotificationLogRepository $notificationLogRepository)
    {
        $this->normalizer = $normalizer;
        $this->notificationLogRepository = $notificationLogRepository;
    }

    /**
     * @param MessageSentEvent $event
     * @throws ORMException
     * @throws ExceptionInterface
     */
    public function __invoke(MessageSentEvent $event)
    {
        try {
            $this->notificationLogRepository->store(
                $this->buildNotificationLog($event)
            );
        } catch (AppException $appException) {
            return;
        }
    }

    /**
     * @throws ExceptionInterface
     */
    protected function buildNotificationLog(MessageSentEvent $event): NotificationLog
    {
        $message = $this->normalizer->normalize($event->getMessage());

        if (false === is_array($message)) {
            throw new AppException("Can't normalize notification message");
        }

        $result = $this->normalizer->normalize($event->getNotificationResult());

        if (false === (is_array($result) || is_null($result))) {
            throw new AppException("Can't normalize notification result");
        }

        return (new NotificationLog($event->getNotificationChannel(), $message))
            ->setResult($result);
    }
}
