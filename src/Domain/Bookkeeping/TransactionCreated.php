<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Bookkeeping;

use UMA\DDD\Foundation\UUID;
use UMA\DDD\EventDispatcher\Event;

class TransactionCreated implements Event
{
    /**
     * @var string
     */
    private $txId;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredAt;

    public function __construct(UUID $txId)
    {
        $this->txId = $txId;
        $this->occurredAt = new \DateTimeImmutable('now');
    }

    public function __toString()
    {
        return json_encode('');
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
