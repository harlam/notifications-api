<?php
declare(strict_types=1);

namespace App\Notification;

use App\Interfaces\RequestInterface;

abstract class AbstractCreateChannelRequest implements RequestInterface, CreateChannelRequestInterface
{
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

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}