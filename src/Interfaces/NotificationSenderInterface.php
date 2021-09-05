<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Notification\AbstractNotificationResult;

interface NotificationSenderInterface
{
    public function send(string $channelKey, object $message): AbstractNotificationResult;
}
