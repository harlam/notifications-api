<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use App\Interfaces\ClientExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

class RequestExceptionHandleListener
{
    public function __invoke(ExceptionEvent $event)
    {
        if ('json' === $event->getRequest()->getContentType() && $event->getThrowable() instanceof ClientExceptionInterface) {
            $event->setResponse(
                $this->buildJsonResponse($event->getThrowable())
            );
        }
    }

    private function buildJsonResponse(Throwable $throwable): JsonResponse
    {
        $result = [
            'message' => $throwable->getMessage()
        ];

        if ($throwable instanceof ValidationException && false === empty($throwable->getViolationsAsArray())) {
            $result['errors'] = $throwable->getViolationsAsArray();
        }

        return new JsonResponse($result, $throwable->getCode());
    }
}
