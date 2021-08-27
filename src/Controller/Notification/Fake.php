<?php

namespace App\Controller\Notification;

use App\Notification\Fake\CreateFakeChannelRequest;
use App\Notification\Fake\FakeMessage;
use App\Notification\Fake\FakeSenderInterface;
use App\Service\Notification\CreateChannelServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(path="/notification/fake")
 */
class Fake extends AbstractController
{
    protected FakeSenderInterface $fakeSender;
    protected CreateChannelServiceInterface $createChannelService;
    protected DenormalizerInterface $serializer;

    public function __construct(
        FakeSenderInterface $fakeSender,
        CreateChannelServiceInterface $createChannelService,
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
     * @Route(path="/channel/{channelKey}", methods={"POST"}, name="notification.fake.send_via_channel")
     */
    public function send(string $channelKey, FakeMessage $message): Response
    {
        $this->fakeSender->send($channelKey, $message);

        return new JsonResponse(null, 201);
    }
}
