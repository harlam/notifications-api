<?php

declare(strict_types=1);

namespace App\Notification\Fake;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Параметры fake-канала отправки сообщений
 *
 * @package App\Notification\Fake
 */
final class FakeChannelConfiguration
{
    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     * @Assert\Length(max=255, min=16)
     */
    protected string $baseUri;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    protected string $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255, min=8)
     */
    protected string $password;

    /**
     * @Assert\Length(max=8, min=3)
     */
    protected ?string $sender = null;

    public function __construct(string $baseUri, string $username, string $password)
    {
        $this->baseUri = $baseUri;
        $this->username = $username;
        $this->password = $password;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }
}
