<?php

declare(strict_types=1);

namespace App\Notification\Fake;

use App\Notification\AbstractCreateChannelRequest;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\Notification\Fake
 */
final class CreateFakeChannelRequest extends AbstractCreateChannelRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    public FakeChannelConfiguration $configuration;

    public function getConfiguration(): FakeChannelConfiguration
    {
        return $this->configuration;
    }
}
