<?php
declare(strict_types=1);

namespace App\Service\Notification;

use App\Entity\NotificationChannel;
use App\Notification\CreateChannelRequestInterface;

interface CreateChannelServiceInterface
{
    public function create(CreateChannelRequestInterface $request): NotificationChannel;
}