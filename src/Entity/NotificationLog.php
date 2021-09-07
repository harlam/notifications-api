<?php

namespace App\Entity;

use App\Repository\NotificationLogRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationLogRepository::class)
 */
class NotificationLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=NotificationChannel::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private NotificationChannel $notificationChannel;

    /**
     * @ORM\Column(type="json")
     */
    private array $message;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $result = null;

    public function __construct(NotificationChannel $notificationChannel, array $message)
    {
        $this->notificationChannel = $notificationChannel;
        $this->message = $message;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotificationChannel(): NotificationChannel
    {
        return $this->notificationChannel;
    }

    public function getMessage(): array
    {
        return $this->message;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function setResult(?array $result): self
    {
        $this->result = $result;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
