<?php
declare(strict_types=1);

namespace App\Notification;

/**
 * Интерфейс запроса на создание канала отправки сообщений
 *
 * @package App\Notification
 */
interface CreateChannelRequestInterface
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
     * @return object|null Параметры канала
     */
    public function getParams(): ?object;
}
