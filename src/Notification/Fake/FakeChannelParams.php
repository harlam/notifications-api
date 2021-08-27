<?php
declare(strict_types=1);

namespace App\Notification\Fake;

/**
 * Параметры канала отправки сообщений
 *
 * @package App\Notification\Fake
 */
final class FakeChannelParams
{
    protected string $baseUri;

    protected string $username;

    protected string $password;

    protected ?string $sender = null;

    protected bool $debugEnabled = false;

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

    public function isDebugEnabled(): bool
    {
        return $this->debugEnabled;
    }

    public function setDebugEnabled(bool $debugEnabled): self
    {
        $this->debugEnabled = $debugEnabled;
        return $this;
    }
}
