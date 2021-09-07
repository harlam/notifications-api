<?php

declare(strict_types=1);

namespace App\RequestResolver;

use App\Exception\RequestValidationException;
use App\Interfaces\RequestInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class RequestValueResolver implements ArgumentValueResolverInterface
{
    private DenormalizerInterface $denormalizer;

    public function __construct(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    /**
     * @throws ReflectionException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (false === is_string($argument->getType())) {
            return false;
        }

        return (new ReflectionClass($argument->getType()))
            ->implementsInterface(RequestInterface::class);
    }

    /**
     * @throws ExceptionInterface
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        try {
            $result = $this->denormalizer->denormalize($request->toArray(), $argument->getType());
        } catch (MissingConstructorArgumentsException $missingConstructorArgumentsException) {
            throw new RequestValidationException('Missing required attributes');
        }

        yield $result;
    }
}
