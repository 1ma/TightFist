<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain\Model\Transaction;

use UMA\TightFist\Context\Bookkeeping\Domain\Model\Account\Account;
use UMA\TightFist\SharedKernel\Domain\UUID;
use UMA\TightFist\SharedKernel\EventDispatcher\EventDispatcher;

class Transaction
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Account
     */
    private $account;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $shortMemo;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher, Account $account, int $amount, string $shortMemo = null)
    {
        $this->id = new UUID();
        $this->account = $account;
        $this->amount = $amount;
        $this->shortMemo = $shortMemo;
        $this->dispatcher = $dispatcher;

        $this->dispatcher
            ->dispatch(new TransactionCreated($this->id, $this->amount));
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
