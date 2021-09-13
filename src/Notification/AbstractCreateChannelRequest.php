<?php

declare(strict_types=1);

namespace App\Notification;

use App\Interfaces\CreateChannelRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractCreateChannelRequest implements CreateChannelRequestInterface
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

    abstract public function getConfiguration(): object;

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
