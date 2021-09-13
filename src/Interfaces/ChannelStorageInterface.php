<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Entity\NotificationChannel;

/**
 * Хранилище каналов отправки
 */
interface ChannelStorageInterface
{
    public function create(CreateChannelRequestInterface $request): NotificationChannel;

    public function getByKey(string $key): NotificationChannel;
}
