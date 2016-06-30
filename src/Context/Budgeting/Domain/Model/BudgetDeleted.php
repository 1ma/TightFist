<?php

namespace UMA\TightFist\Context\Budgeting\Domain\Model;

use UMA\TightFist\SharedKernel\Domain\UUID;
use UMA\TightFist\SharedKernel\EventDispatcher\Event;

class BudgetDeleted implements Event
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
        return json_encode((string) $this->budgetId);
    }

    public function occurredAt(): \DateTime
    {
        return $this->occurredAt;
    }
}
