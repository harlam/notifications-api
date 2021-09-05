<?php

declare(strict_types=1);

namespace App\Notification;

use App\Interfaces\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Запрос на создание канала отправки оповещений
 */
abstract class AbstractCreateChannelRequest implements RequestInterface
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

    /**
     * @return string Название канала отправки
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null Описание канала
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return object|null Конфигурация канала
     */
    abstract public function getConfiguration(): ?object;
}