<?php

declare(strict_types=1);

namespace App\Notification;

use App\Entity\NotificationChannel;
use App\Exception\RequestValidationException;
use App\Interfaces\CreateNotificationChannelRequestInterface;
use App\Interfaces\CreateNotificationChannelInterface;
use App\Interfaces\RequestValidatorInterface;
use App\Interfaces\SecretKeyGeneratorInterface;
use App\Repository\NotificationChannelRepository;
use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
    public function create(CreateNotificationChannelRequestInterface $request): NotificationChannel
    {
        $this->requestValidator->assertValid($request);

        $notificationChannel = (new NotificationChannel(
            $this->secretKeyGenerator->generate(),
            $request->getName(),
            $this->buildParams($request)
        ))->setDescription($request->getDescription());

        $this->repository->store($notificationChannel);

        return $notificationChannel;
    }

    /**
     * @throws ExceptionInterface
     * @throws Exception
     */
    protected function buildParams(CreateNotificationChannelRequestInterface $request): ?array
    {
        $params = ($p = $request->getParams()) === null ? null : $this->normalizer->normalize($p);

        if (is_array($params) || is_null($params)) {
            return $params;
        }

        throw new Exception('Bad params type');
    }
}
