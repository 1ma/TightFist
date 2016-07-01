<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Model\Bookkeeping;

use UMA\DDD\Foundation\UUID;
use UMA\DDD\EventDispatcher\Event;
use UMA\DDD\Foundation\ValueObject;

class AccountCreated implements Event
{
    /**
     * @var UUID
     */
    private $accountId;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredAt;

    public function __construct(UUID $accountId)
    {
        $this->accountId = $accountId;
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
