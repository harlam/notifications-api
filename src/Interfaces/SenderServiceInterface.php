<?php

namespace App\Interfaces;

use Notification\Common\NotificationResultInterface;

interface SenderServiceInterface
{
    /**
     * @param string $key channel key
     * @param object $message
     * @return NotificationResultInterface
     */
    public function send(string $key, object $message): NotificationResultInterface;
}
