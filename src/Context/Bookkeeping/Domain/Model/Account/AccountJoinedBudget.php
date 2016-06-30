<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain\Model\Account;


use UMA\TightFist\SharedKernel\EventDispatcher\Event;

class AccountJoinedBudget implements Event
{
    public function occurredAt(): \DateTime
    {
    }

    public function __toString()
    {
        return '';
    }
}
