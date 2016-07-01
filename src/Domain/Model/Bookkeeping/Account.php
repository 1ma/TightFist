<?php

namespace UMA\TightFist\Domain\Model\Bookkeeping;

use UMA\TightFist\Domain\Model\Budgeting\Budget;
use UMA\TightFist\SharedKernel\Domain\UUID;
use UMA\TightFist\SharedKernel\EventDispatcher\EventDispatcher;

class Account
{
    /**
     * @var UUID
     */
    private $id;

    /**
     * @var Budget
     */
    private $budget;

    /**
     * @var Transaction[]
     */
    private $transactions;

    public function __construct()
    {
        $this->id = new UUID();
        $this->budget = null;
        $this->transactions = [];
    }

    public function getId(): UUID
    {
        return $this->id;
    }

    /**
     * @param int         $amount
     * @param string|null $shortMemo
     *
     * @return Transaction
     */
    public function makeTransaction(int $amount, string $shortMemo = null): Transaction
    {
        $transaction = new Transaction($this, $amount, $shortMemo);

        $this->transactions[] = $transaction;

        return $transaction;
    }

    public function joinBudget(Budget $budget): Account
    {
        $this->budget = $budget;

        return $this;
    }

    public function leaveBudget(): Account
    {
        $this->budget = null;

        return $this;
    }
}
