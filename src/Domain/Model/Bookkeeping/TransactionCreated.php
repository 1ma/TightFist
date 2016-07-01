<?php

namespace UMA\TightFist\Domain\Model\Bookkeeping;

use UMA\TightFist\SharedKernel\Domain\UUID;
use UMA\TightFist\SharedKernel\EventDispatcher\Event;

class TransactionCreated implements Event
{
    /**
     * @var string
     */
    private $txId;

    /**
     * @var \DateTime
     */
    private $occurredAt;

    public function __construct(UUID $txId)
    {
        $this->txId = $txId;
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
