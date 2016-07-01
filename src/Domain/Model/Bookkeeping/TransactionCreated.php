<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Model\Bookkeeping;

use UMA\DDD\Foundation\UUID;
use UMA\DDD\EventDispatcher\Event;
use UMA\DDD\Foundation\ValueObject;

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

    public function equals(ValueObject $object): bool
    {
        return false;
    }
}
