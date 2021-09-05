<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\NotificationChannel;
use App\Exception\RequestValidationException;
use App\Interfaces\CreateNotificationChannelInterface;
use App\Interfaces\RequestValidatorInterface;
use App\Interfaces\SecretKeyGeneratorInterface;
use App\Notification\AbstractCreateChannelRequest;
use App\Repository\NotificationChannelRepository;
use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Создание канала отправки оповещений с заданной конфигурацией
 */
final class CreateNotificationChannel implements CreateNotificationChannelInterface
{
    protected RequestValidatorInterface $requestValidator;
    protected NotificationChannelRepository $repository;
    protected NormalizerInterface $normalizer;
    protected SecretKeyGeneratorInterface $secretKeyGenerator;

    public function __construct(
        RequestValidatorInterface $requestValidator,
        NotificationChannelRepository $repository,
        NormalizerInterface $normalizer,
        SecretKeyGeneratorInterface $secretKeyGenerator
    )
    {
        $this->requestValidator = $requestValidator;
        $this->repository = $repository;
        $this->normalizer = $normalizer;
        $this->secretKeyGenerator = $secretKeyGenerator;
    }

    /**
     * @throws RequestValidationException
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function create(AbstractCreateChannelRequest $request): NotificationChannel
    {
        $this->requestValidator->assertValid($request);

        $notificationChannel = (new NotificationChannel(
            $this->secretKeyGenerator->generate(),
            $request->getName(),
            $this->buildConfiguration($request)
        ))->setDescription($request->getDescription());

        $this->repository->store($notificationChannel);

        return $notificationChannel;
    }

    /**
     * @throws ExceptionInterface
     * @throws Exception
     */
    protected function buildConfiguration(AbstractCreateChannelRequest $request): ?array
    {
        $configuration = ($c = $request->getConfiguration()) === null ? null : $this->normalizer->normalize($c);

        if (is_array($configuration) || is_null($configuration)) {
            return $configuration;
        }

        throw new Exception('Configuration build error');
    }
}
