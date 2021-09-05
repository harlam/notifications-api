<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Entity\NotificationChannel;
use App\Notification\AbstractCreateChannelRequest;

/**
 * Создание канала отправки оповещений
 */
interface CreateNotificationChannelInterface
{
    public function create(AbstractCreateChannelRequest $request): NotificationChannel;
}
