<?php

namespace App\Entity;

use App\Repository\NotificationChannelRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationChannelRepository::class)
 */
class NotificationChannel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private string $key;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $configuration;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $isActive = true;

    public function __construct(string $key, string $name, ?array $configuration = null)
    {
        $this->key = $key;
        $this->name = $name;
        $this->configuration = $configuration;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getConfiguration(): ?array
    {
        return $this->configuration;
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

    public function setIsActive(bool $active): self
    {
        $this->isActive = $active;
        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }
}
