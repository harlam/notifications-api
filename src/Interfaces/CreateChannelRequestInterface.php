<?php

declare(strict_types=1);

namespace App\Interfaces;

use Notification\Common\RequestInterface;

/**
 * Запрос на создание канала отправки
 */
interface CreateChannelRequestInterface extends RequestInterface
{
    /**
     * @return string Название канала отправки
     */
    public function getName(): string;

    /**
     * @return string|null Описание канала
     */
    public function getDescription(): ?string;

    /**
     * @return object Конфигурация канала
     */
    public function getConfiguration(): object;
}
