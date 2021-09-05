<?php

declare(strict_types=1);

namespace App\Notification\Fake;

use App\Interfaces\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class FakeMessage implements RequestInterface
{
    /**
     * @Assert\Type(type="array")
     * @Assert\Count(min=1)
     */
    protected array $recipients;

    /**
     * @Assert\NotBlank
     */
    protected string $message;

    public function __construct(string $message, string ...$recipients)
    {
        $this->message = $message;
        $this->recipients = $recipients;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
