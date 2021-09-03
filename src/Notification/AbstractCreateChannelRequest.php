<?php

declare(strict_types=1);

namespace App\Notification;

use App\Interfaces\CreateNotificationChannelRequestInterface;
use App\Interfaces\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractCreateChannelRequest implements RequestInterface, CreateNotificationChannelRequestInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255, min=8)
     */
    protected string $name;

    protected ?string $description = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}