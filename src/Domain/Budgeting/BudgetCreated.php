<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Budgeting;

use UMA\DDD\Foundation\UUID;
use UMA\DDD\EventDispatcher\Event;

class BudgetCreated implements Event
{
    /**
     * @var UUID
     */
    private $budgetId;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredAt;

    public function __construct(UUID $budgetId)
    {
        $this->budgetId = $budgetId;
        $this->occurredAt = new \DateTimeImmutable('now');
    }

    public function __toString()
    {
        return (string) $this->budgetId;
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
