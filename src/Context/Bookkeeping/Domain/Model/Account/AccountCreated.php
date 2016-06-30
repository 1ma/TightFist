<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain\Model\Account;

use UMA\TightFist\Context\Bookkeeping\Domain\Model\Budget\BudgetId;
use UMA\TightFist\SharedKernel\Domain\UUID;
use UMA\TightFist\SharedKernel\EventDispatcher\Event;

class AccountCreated implements Event
{
    /**
     * @var UUID
     */
    private $accountId;

    /**
     * @var BudgetId
     */
    private $budgetId;

    /**
     * @var \DateTime
     */
    private $occurredAt;

    public function __construct(UUID $accountId, BudgetId $budgetId = null)
    {
        $this->accountId = $accountId;
        $this->budgetId = $budgetId;
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
