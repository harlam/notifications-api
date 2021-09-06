<?php

declare(strict_types=1);

namespace App\Notification;

use App\Entity\NotificationChannel;
use App\Event\NotificationMessageSentEvent;
use App\Exception\RequestValidationException;
use App\Exception\ValidationException;
use App\Interfaces\NotificationSenderInterface;
use App\Interfaces\RequestValidatorInterface;
use App\Repository\NotificationChannelRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractNotificationSender implements NotificationSenderInterface
{
    protected RequestValidatorInterface $requestValidator;
    protected ValidatorInterface $validator;
    protected NotificationChannelRepository $channelRepository;
    protected DenormalizerInterface $denormalizer;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(
        RequestValidatorInterface $requestValidator,
        ValidatorInterface $validator,
        NotificationChannelRepository $channelRepository,
        DenormalizerInterface $denormalizer,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->requestValidator = $requestValidator;
        $this->validator = $validator;
        $this->channelRepository = $channelRepository;
        $this->denormalizer = $denormalizer;
        $this->eventDispatcher = $eventDispatcher;
    }

    abstract protected function getMessageClass(): string;

    abstract protected function getConfigurationClass(): string;

    abstract protected function process(object $message, object $configuration): AbstractNotificationResult;

    /**
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     * @throws ExceptionInterface
     * @throws ValidationException
     */
    public function send(string $channelKey, object $message): AbstractNotificationResult
    {
        $this->assertMessageValid($message);

        $channel = $this->getNotificationChannel($channelKey);

        $configuration = $this->getConfiguration($channel);

        $this->assertConfigurationValid($configuration);

        $result = $this->process($message, $configuration);

        $this->eventDispatcher->dispatch(
            new NotificationMessageSentEvent($channel, $message, $result)
        );

        return $result;
    }

    /**
     * @throws RequestValidationException
     * @throws ValidationException
     */
    protected function assertMessageValid(object $message): void
    {
        $supportedClass = $this->getMessageClass();

        if (!($message instanceof $supportedClass)) {
            $messageClass = get_class($message);
            throw new ValidationException("Incorrect message type '$messageClass'. '$supportedClass' expected.");
        }

        $this->requestValidator->assertValid($message);
    }

    /**
     * @throws RequestValidationException
     * @throws ValidationException
     */
    protected function assertConfigurationValid(object $configuration): void
    {
        $errors = $this->validator->validate($configuration);

        if (count($errors) > 0) {
            throw ValidationException::create($errors, 'Sender configuration is incorrect');
        }
    }

    /**
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    protected function getNotificationChannel(string $channelKey): NotificationChannel
    {
        return $this->channelRepository->getByKey($channelKey);
    }

    /**
     * @throws ExceptionInterface
     */
    protected function getConfiguration(NotificationChannel $channel): ?object
    {
        $rawConfiguration = $channel->getConfiguration();

        if ($rawConfiguration === null) {
            return null;
        }

        return $this->denormalizer->denormalize($rawConfiguration, $this->getConfigurationClass());
    }
}
