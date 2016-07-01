<?php

declare(strict_types = 1);

namespace UMA\TightFist\Domain\Model\Budgeting;

use UMA\TightFist\SharedKernel\Domain\UUID;
use UMA\TightFist\SharedKernel\EventDispatcher\Event;

class BudgetCreated implements Event
{
    /**
     * @var UUID
     */
    private $budgetId;

    /**
     * @var \DateTime
     */
    private $occurredAt;

    public function __construct(UUID $budgetId)
    {
        $this->budgetId = $budgetId;
        $this->occurredAt = new \DateTime('now');
    }

    public function __toString()
    {
        return (string) $this->budgetId;
    }

    public function occurredAt(): \DateTime
    {
        return $this->occurredAt;
    }
}
