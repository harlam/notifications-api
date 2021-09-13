<?php

declare(strict_types=1);

namespace App\Notification\Fake;

use App\Notification\AbstractCreateChannelRequest;
use Notification\Fake\FakeSenderConfiguration;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateFakeChannelRequest extends AbstractCreateChannelRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    public FakeSenderConfiguration $configuration;

    public function getConfiguration(): FakeSenderConfiguration
    {
        return $this->configuration;
    }
}
