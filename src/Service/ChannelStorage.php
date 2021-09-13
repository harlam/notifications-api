<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\NotificationChannel;
use App\Exception\AppException;
use App\Exception\RequestValidationException;
use App\Interfaces\CreateChannelRequestInterface;
use App\Interfaces\ChannelStorageInterface;
use App\Interfaces\RequestValidatorInterface;
use App\Interfaces\SecretKeyGeneratorInterface;
use App\Repository\NotificationChannelRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ChannelStorage implements ChannelStorageInterface
{
    private NotificationChannelRepository $repository;

    private NormalizerInterface $normalizer;

    private RequestValidatorInterface $requestValidator;

    private SecretKeyGeneratorInterface $secretKeyGenerator;

    public function __construct(
        NotificationChannelRepository $repository,
        NormalizerInterface $normalizer,
        RequestValidatorInterface $requestValidator,
        SecretKeyGeneratorInterface $secretKeyGenerator
    )
    {
        $this->repository = $repository;
        $this->normalizer = $normalizer;
        $this->requestValidator = $requestValidator;
        $this->secretKeyGenerator = $secretKeyGenerator;
    }

    /**
     * @throws RequestValidationException
     * @throws ExceptionInterface
     * @throws ORMException
     */
    public function create(CreateChannelRequestInterface $request): NotificationChannel
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
     * @throws NonUniqueResultException
     * @throws EntityNotFoundException
     */
    public function getByKey(string $key): NotificationChannel
    {
        return $this->repository->getByKey($key);
    }

    /**
     * @throws ExceptionInterface
     * @throws AppException
     */
    private function buildConfiguration(CreateChannelRequestInterface $request): array
    {
        $configuration = $this->normalizer->normalize(
            $request->getConfiguration()
        );

        if (false === is_array($configuration)) {
            throw new AppException('Configuration build error');
        }

        return $configuration;
    }
}
