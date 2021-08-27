<?php
declare(strict_types=1);

namespace App\Notification\Fake;

use App\Notification\AbstractCreateChannelRequest;

/**
 * Запрос на создание канала отправки сообщений
 *
 * @package App\Notification\Fake
 */
final class CreateFakeChannelRequest extends AbstractCreateChannelRequest
{
    protected ?FakeChannelParams $params = null;

    public function setParams(?FakeChannelParams $params): void
    {
        $this->params = $params;
    }

    public function getParams(): ?FakeChannelParams
    {
        return $this->params;
    }
}