<?php

namespace App\Controller\Notification;

use App\Interfaces\CreateNotificationChannelInterface;
use App\Notification\Fake\CreateFakeChannelRequest;
use App\Notification\Fake\FakeMessage;
use App\Notification\Fake\FakeSender;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(path="/notification/fake")
 */
class Fake extends AbstractController
{
    protected FakeSender $fakeSender;
    protected CreateNotificationChannelInterface $createChannelService;
    protected DenormalizerInterface $serializer;

    public function __construct(
        FakeSender $fakeSender,
        CreateNotificationChannelInterface $createChannelService,
        SerializerInterface $serializer
    )
    {
        $this->fakeSender = $fakeSender;
        $this->createChannelService = $createChannelService;
        $this->serializer = $serializer;
    }

    /**
     * @Route(path="/channel", methods={"POST"}, name="notification.fake.create_channel")
     */
    public function createChannel(CreateFakeChannelRequest $request): Response
    {
        $notificationChannel = $this->createChannelService->create($request);

        return JsonResponse::fromJsonString(
            $this->serializer->serialize($notificationChannel, 'json')
        );
    }

    /**
     * @Route(path="/channel/{key}", methods={"POST"}, name="notification.fake.send_via_channel")
     *
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     * @throws ExceptionInterface
     */
    public function send(string $key, FakeMessage $message): Response
    {
        $this->fakeSender->send($key, $message);

        return new JsonResponse(null, 201);
    }
}
