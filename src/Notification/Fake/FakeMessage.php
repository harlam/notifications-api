<?php
declare(strict_types=1);

namespace App\Notification\Fake;

use App\Interfaces\RequestInterface;

final class FakeMessage implements RequestInterface
{
    /**
     * @var string[]
     */
    protected array $recipients;

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
