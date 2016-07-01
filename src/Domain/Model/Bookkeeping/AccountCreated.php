<?php

namespace UMA\TightFist\Domain\Model\Bookkeeping;

use UMA\TightFist\SharedKernel\Domain\UUID;
use UMA\TightFist\SharedKernel\EventDispatcher\Event;

class AccountCreated implements Event
{
    /**
     * @var UUID
     */
    private $accountId;

    /**
     * @var \DateTime
     */
    private $occurredAt;

    public function __construct(UUID $accountId)
    {
        $this->accountId = $accountId;
        $this->occurredAt = new \DateTime('now');
    }

    public function __toString()
    {
        return json_encode('');
    }

    public function occurredAt(): \DateTime
    {
        return $this->occurredAt;
    }
}
