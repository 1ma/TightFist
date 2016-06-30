<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain\Model\Account;

use UMA\TightFist\Context\Bookkeeping\Domain\Model\Budget\BudgetId;
use UMA\TightFist\Context\Bookkeeping\Domain\Model\Transaction\Transaction;
use UMA\TightFist\SharedKernel\Domain\UUID;
use UMA\TightFist\SharedKernel\EventDispatcher\EventDispatcher;

class Account
{
    /**
     * @var UUID
     */
    private $id;

    /**
     * @var BudgetId
     */
    private $budgetId;

    /**
     * @var Transaction[]
     */
    private $transactions;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher, BudgetId $budgetId = null)
    {
        $this->id = new UUID();
        $this->budgetId = $budgetId;
        $this->transactions = [];

        $this->dispatcher = $dispatcher;

        $this->dispatcher
            ->dispatch(new AccountCreated($this->id, $this->budgetId));
    }

    /**
     * @param int         $amount
     * @param string|null $shortMemo
     *
     * @return Transaction
     */
    public function makeTransaction(int $amount, string $shortMemo = null): Transaction
    {
        $transaction = new Transaction($this->dispatcher, $this, $amount, $shortMemo);

        $this->transactions[] = $transaction;

        return $transaction;
    }

    public function joinBudget(BudgetId $budgetId): Account
    {
        $this->budgetId = $budgetId;

        $this->dispatcher
            ->dispatch(new AccountJoinedBudget($this->id, $this->budgetId));

        return $this;
    }

    public function leaveBudget(): Account
    {
        if (null !== $oldBudgetId = $this->budgetId) {
            $this->budgetId = null;

            $this->dispatcher
                ->dispatch(new AccountLeftBudget($this->id, $oldBudgetId));
        }

        return $this;
    }
}
