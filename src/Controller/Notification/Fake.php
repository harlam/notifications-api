<?php

declare(strict_types=1);

namespace App\Controller\Notification;

use App\Interfaces\ChannelStorageInterface;

use App\Notification\Fake\CreateFakeChannelRequest;
use App\Notification\Fake\FakeSenderServiceInterface;
use Notification\Fake\FakeMessage;
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
    protected FakeSenderServiceInterface $fakeSender;
    protected ChannelStorageInterface $channelStorage;
    protected DenormalizerInterface $serializer;

    public function __construct(
        FakeSenderServiceInterface $fakeSender,
        ChannelStorageInterface $channelStorage,
        SerializerInterface $serializer
    )
    {
        $this->fakeSender = $fakeSender;
        $this->channelStorage = $channelStorage;
        $this->serializer = $serializer;
    }

    /**
     * @Route(path="/channel", methods={"POST"}, name="notification.fake.create_channel")
     */
    public function createChannel(CreateFakeChannelRequest $request): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize($this->channelStorage->create($request), 'json')
        );
    }

    /**
     * @Route(path="/channel/{key}", methods={"POST"}, name="notification.fake.send_via_channel")
     */
    public function send(string $key, FakeMessage $message): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize($this->fakeSender->send($key, $message), 'json')
        );
    }
}
