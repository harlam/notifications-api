<?php
declare(strict_types=1);

namespace App\Service\Notification;

use App\Entity\NotificationChannel;
use App\Exception\RequestValidationException;
use App\Interfaces\SecretKeyGeneratorInterface;
use App\Notification\CreateChannelRequestInterface;
use App\Repository\NotificationChannelRepository;
use App\Service\AbstractService;
use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CreateChannelService extends AbstractService implements CreateChannelServiceInterface
{
    protected NotificationChannelRepository $repository;
    protected NormalizerInterface $normalizer;
    protected SecretKeyGeneratorInterface $secretKeyGenerator;

    public function __construct(
        NotificationChannelRepository $repository,
        NormalizerInterface $normalizer,
        SecretKeyGeneratorInterface $secretKeyGenerator
    )
    {
        $this->repository = $repository;
        $this->normalizer = $normalizer;
        $this->secretKeyGenerator = $secretKeyGenerator;
    }

    /**
     * @throws RequestValidationException
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function create(CreateChannelRequestInterface $request): NotificationChannel
    {
        $this->assertValid($request);

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
    protected function buildParams(CreateChannelRequestInterface $request): ?array
    {
        $params = ($p = $request->getParams()) === null ? null : $this->normalizer->normalize($p);

        if (is_array($params) || is_null($params)) {
            return $params;
        }

        throw new Exception('Bad params type');
    }
}
