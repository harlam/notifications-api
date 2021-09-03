<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Entity\NotificationChannel;

interface CreateNotificationChannelInterface
{
    public function create(CreateNotificationChannelRequestInterface $request): NotificationChannel;
}
