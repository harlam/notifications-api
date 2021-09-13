<?php

declare(strict_types=1);

namespace App\Notification;

use App\Entity\NotificationChannel;
use App\Event\MessageSentEvent;
use App\Exception\RequestValidationException;
use App\Exception\ValidationException;
use App\Interfaces\ChannelStorageInterface;
use App\Interfaces\RequestValidatorInterface;
use App\Interfaces\SenderServiceInterface;
use Notification\Common\NotificationResultInterface;
use Notification\Common\SenderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractSenderService implements SenderServiceInterface
{
    protected RequestValidatorInterface $validator;

    protected ChannelStorageInterface $channelStorage;

    protected DenormalizerInterface $denormalizer;

    protected EventDispatcherInterface $eventDispatcher;

    protected NotificationChannel $channel;

    protected object $configuration;

    public function __construct(
        RequestValidatorInterface $validator,
        ChannelStorageInterface $channelStorage,
        DenormalizerInterface $denormalizer,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->validator = $validator;
        $this->channelStorage = $channelStorage;
        $this->denormalizer = $denormalizer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return string[]
     */
    abstract protected function getSupportedMessages(): array;

    abstract protected function getConfigurationClass(): string;

    abstract protected function buildSender(): SenderInterface;


    /**
     * @throws ExceptionInterface
     */
    protected function init(string $key): self
    {
        $this->channel = $this->channelStorage->getByKey($key);

        $this->configuration = $this->denormalizer->denormalize(
            $this->getChannel()->getConfiguration(),
            $this->getConfigurationClass()
        );

        $errors = $this->validator->getValidator()->validate($this->configuration);

        if (count($errors) > 0) {
            throw (new ValidationException('Configuration is incorrect'))
                ->setViolations($errors);
        }

        return $this;
    }

    /**
     * @throws RequestValidationException
     * @throws ValidationException
     */
    protected function assertMessageValid(object $message): void
    {
        $messageClass = get_class($message);

        if (false === in_array($messageClass, $this->getSupportedMessages())) {
            throw new RequestValidationException("Message with type '$messageClass' is not supported");
        }

        $this->validator->assertValid($message);
    }

    /**
     * @throws ExceptionInterface
     * @throws ValidationException
     */
    public function send(string $key, object $message): NotificationResultInterface
    {
        $this->assertMessageValid($message);

        $this->init($key);

        $sent = $this->buildSender()->send($message);

        $this->eventDispatcher->dispatch(
            new MessageSentEvent($this->getChannel(), $message, $sent)
        );

        return $sent;
    }

    public function getChannel(): NotificationChannel
    {
        return $this->channel;
    }

    protected function getConfiguration(): object
    {
        return $this->configuration;
    }
}
