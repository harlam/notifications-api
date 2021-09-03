<?php

declare(strict_types=1);

namespace App\Notification\Fake;

use App\Notification\AbstractCreateChannelRequest;

/**
 * @package App\Notification\Fake
 */
final class CreateFakeChannelRequest extends AbstractCreateChannelRequest
{
    public ?FakeChannelConfiguration $params = null;

    public function getParams(): ?FakeChannelConfiguration
    {
        return $this->params;
    }
}
